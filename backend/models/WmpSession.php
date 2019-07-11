<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\helpers\Html;
use drodata\helpers\Utility;
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;
use drodata\behaviors\LookupBehavior;

/**
 * This is the model class for table "wmp_session".
 * 
 * @property string $open_id
 * @property integer $user_id
 * @property string $value
 * @property integer $expires_at
 *
 * @property User $user
 */
class WmpSession extends \drodata\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        // custom code follows
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wmp_session';
    }


    /**
     * key means scenario names
     */
    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'lookup' => [
                'class' => LookupBehavior::className(),
                'labelMap' => [
                    'visible' => ['boolean', []],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_id', 'user_id', 'value', 'expires_at'], 'required'],
            [['user_id', 'expires_at'], 'integer'],
            [['open_id', 'value'], 'string', 'max' => 100],
            [['value'], 'unique'],
            [['open_id', 'user_id'], 'unique', 'targetAttribute' => ['open_id', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
        /**
         * CODE TEMPLATE
         *
            ['passwordOld', 'inlineV'],
            [
                'billing_period', 'required', 
                'when' => function ($model, $attribute) {
                    return $model->payment_way != self::PAYMENT_WAY_SINGLE;
                },
                'on' => self::SCENARIO_ACCOUNTANT,
                'whenClient' => "function (attribute, value) {
                    return $('#company-payment_way input:checked').val() != '1';
                }",
            ],
        */
    }

    /**
     * CODE TEMPLATE inline validator
     *
    public function inlineV($attribute, $params, $validator)
    {
        if ($this->$attribute != 'a') {
            $this->addError($attribute, 'error message');
            return false;
        }
        return true;
    }
    */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'open_id' => 'Open ID',
            'user_id' => 'User ID',
            'value' => 'Value',
            'expires_at' => 'Expires At',
        ];
    }

    /**
     * 反回操作链接
     *
     * @param string $action action name
     * @param array $configs 参考 Html::actionLink()
     * @return mixed the link html content
     */
    public function actionLink($action, $configs = [])
    {
        list($route, $options) = $this->getActionOptions($action);

        return Html::actionLink($route, ArrayHelper::merge($options, $configs));
    }

    /**
     * 返回 actionLink() 核心属性
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 两个个元素依次表示：action route, action link options
     *
     */
    public function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/wmp-session/$action", 'open_id' => $this->open_id, 'user_id' => $this->user_id];

        switch ($action) {
            case 'view':
                $options = [
                    'title' => '查看',
                    'icon' => 'eye',
                    // disable modal view feature by commenting the following line.
                    'class' => 'modal-view',
                ];
                break;
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                //$visible = Yii::$app->user->can('x');
                if (0) {
                    $hint = 'xx';
                }
                break;

            case 'delete':
                $options = [
                    'title' => '删除',
                    'icon' => 'trash',
                    'color' => 'danger',
                    'data' => [
                        'method' => 'post',
                        'confirm' => '确定要执行删除操作吗？',
                    ],
                ];
                //$visible = Yii::$app->user->can('x');
                if (0) {
                    $hint = 'xx';
                }
                break;

            default:
                break;
        }

        // combine control options with common options
        return [$route, ArrayHelper::merge($options, [
            'type' => 'icon',
            'visible' => $visible,
            'disabled' => $hint,
            'disabledHint' => $hint,
        ])];
    }

    // ==== getters start ====

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * 通用的、无需 sort 和 pagination 的 data provider
     * @param string $key 
     */
    public function getDataProvider($key)
    {
        switch ($key) {
            default:
                $query = null;
                break;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
    }


    // ==== getters end ====

    /**
     * 服务端在获取小程序用户的 openid 后，部署自有会话并返回
     *
     * 若用户首次访问，在 user 表中新增记录，在 wmp_session 新增自有会话记录并返回；后续用户访问时，自动刷新自有会话和过期时间。
     * @param string $openid
     * @return WampSession instance
     */
    public static function deploy($openid)
    {
        $model = static::findOne(['open_id' => $openid]);

        if (empty($model)) {
            $user = new User(['scenario' => User::SCENARIO_CUSTOMER, 'status' => 1]); 
            $user->generateUserName();
            $user->on(User::EVENT_BEFORE_INSERT, [$user, 'generateRandomPassword']);
            $user->on(User::EVENT_AFTER_INSERT, [$user, 'insertCustomer']);

            if (!$user->save()) {
                throw new Exception('Failed to save.');
            }

            $model = new WmpSession([
                'open_id' => $openid,
                'user_id' => $user->id,
            ]);
        }

        $model->value = Yii::$app->security->generateRandomString();
        $model->expires_at = time() + 3600 * 10; // 10 days later
        if (!$model->save()) {
            throw new Exception('Failed to save.');
        }

        return $model;
    }

    /**
     * CODE TEMPLATE
     *
    public function sign()
    {
        $this->status = 3;
        if (!$this->save()) {
            throw new Exception('Failed to save.');
        }
    }
     */


    // ==== event-handlers begin ====

    // ==== event-handlers end ====
}
