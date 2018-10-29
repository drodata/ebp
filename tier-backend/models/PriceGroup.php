<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\models\Currency;
use drodata\helpers\Html;
use drodata\helpers\Utility;
use drodata\behaviors\LookupBehavior;

/**
 * This is the model class for table "price_group".
 * 
 * @property integer $id
 * @property string $currency_code
 * @property string $name
 * @property integer $is_base
 * @property string $offset
 *
 * @property Price[] $prices
 * @property Currency $currencyCode
 */
class PriceGroup extends \drodata\db\ActiveRecord
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
        return 'price_group';
    }


    /**
     * @inheritdoc
     * @return PriceGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PriceGroupQuery(get_called_class());
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
                    'is_base' => ['boolean', []],
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
            [['is_base'], 'default', 'value' => 0],
            [['currency_code', 'name', 'is_base'], 'required'],
            [['is_base'], 'integer'],
            [['offset'], 'number'],
            [['currency_code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 45],
            [['currency_code'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_code' => 'code']],
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
            'id' => '价格组编号',
            'currency_code' => '币种',
            'name' => '名称',
            'is_base' => '基础分组',
            'offset' => '折扣',
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
        $route = ["/price-group/$action", 'id' => $this->id];

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
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['price_group_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyCode()
    {
        return $this->hasOne(Currency::className(), ['code' => 'currency_code']);
    }

    // ==== getters end ====

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
