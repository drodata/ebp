<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\behaviors\BlameableBehavior;
use drodata\helpers\Html;
use drodata\behaviors\TimestampBehavior;

/**
 * This is the model class for table "map".
 *
 * @property string $id
 * @property string $type
 * @property string $from_id
 * @property string $to_id
 */
class Map extends \yii\db\ActiveRecord
{
    //const EVENT_ = '';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_AFTER_SAVE, [$this, 'handlerName']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
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
            /*
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
            ],
            */
        ];
    }

    /**
     * @inheritdoc
     *
    public function fields()
    {
        $fields = parent::fields();
        
        // 删除涉及敏感信息的字段
        unset($fields['auth_key']);
        
        // 增加自定义字段
        return ArrayHelper::merge($fields, [
            'fullName' => function () {
                return $this->id . $this->username;
            },
            'group' => function () {
                return $this->group;
            },
        ]);
    }
    */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'from_id', 'to_id'], 'required'],
            [['from_id', 'to_id'], 'integer'],
            [['type'], 'string', 'max' => 100],
        ];
        //['passwordOld', 'inlineV'],
    }

    /* inline validator
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
            'id' => 'ID',
            'type' => 'Type',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
        ];
    }

    /**
     * Render a specified action link, which is usually used in 
     * GridView or ListView.
     *
     * @param string $action action name
     * @param string $type link type, 'icon' and 'button' are available,
     * the former is used in action column in grid view, while the latter
     * is use in list view.
     * @return mixed the link html content
     */
    public function actionLink($action, $type = 'icon')
    {
        $route = '/map/' . $action;
        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        // comment the next line if you don't want to view model in modal.
                        'class' => 'modal-view',
                    ]
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                    ]
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => '请再次确认删除操作。',
                        ],
                    ]
                );
                break;
        }
    }

    // ==== getters start ====


    // ==== getters end ====

    /**
     * Transaction block template
     *
    public function create($data)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save()) {
                throw new \yii\db\Exception('Failed to insert xxx.');
            }

            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    */

    // ==== event-handlers begin ====
    // ==== event-handlers end ====
}
