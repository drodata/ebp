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
use drodata\behaviors\LookupBehavior;

/**
 * This is the model class for table "sku".
 * 
 * @property integer $id
 * @property integer $spu_id
 * @property string $name
 * @property integer $status
 * @property integer $visible
 * @property integer $stock
 * @property integer $threshold
 * @property string $description
 * @property string $introduction
 *
 * @property Spu $spu
 * @property SkuSpecification[] $skuSpecifications
 */
class Sku extends \drodata\db\ActiveRecord
{
    // const STATUS_ = 1;
    // const SCENARIO_ = '';
    // 单独上传附件事件
    const EVENT_UPLOAD = 'upload';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteItems']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sku';
    }


    /**
     * @inheritdoc
     * @return SkuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkuQuery(get_called_class());
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
                    'status' => ['status', [ ]],
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
            [['status'], 'default', 'value' => 1],

            [['spu_id', 'name', 'status'], 'required'],
            [['spu_id', 'status', 'visible', 'stock', 'threshold'], 'integer'],
            [['introduction'], 'string'],
            [['name', 'description'], 'string', 'max' => 255],
            [['spu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Spu::className(), 'targetAttribute' => ['spu_id' => 'id']],
        ];
        //['passwordOld', 'inlineV'],
        /*
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
            'spu_id' => 'Spu ID',
            'name' => '名称',
            'status' => '状态',
            'visible' => 'Visible',
            'stock' => '库存',
            'threshold' => '库存预警值',
            'description' => '简介',
            'introduction' => '详细介绍',
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
     * @param array $configs 动态配置数组。内容参见 Html::actionLink(). 例如 'view' 动作默认的 title 为 '详情',
     * 我想改成 "查看订单": `Html::actionLink('view', 'icon', ['title' => '查看订单'])
     * @return mixed the link html content
     */
    public function actionLink($action, $type = 'icon', $configs = [])
    {
        $route = '/sku/' . $action;
        list($visible, $hint, $confirm) = $this->getActionOptions($action);

        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        // comment the next line if you don't want to view model in modal.
                        'class' => 'modal-view',
                    ], $configs)
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                        'visible' => $visible,
                        'disabled' => $hint,
                        'disabledHint' => $hint,
                    ], $configs)
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => $confirm,
                        ],
                        'visible' => $visible,
                        'disabled' => $hint,
                        'disabledHint' => $hint,
                    ], $configs)
                );
                break;
        }
    }

    /**
     * 返回 $action 常见的选项
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 三个元素依次表示：按钮可见性、禁用提示和确认提示
     *
     */
    public function getActionOptions($action)
    {
        $visible = true;
        $hint = null;
        $confirm = null;

        switch ($action) {
            case 'update':
                $visible = $visible && true;

                if (0) {
                    $hint = 'already paid';
                }
                break;
            case 'delete':
                $visible = $visible && true;

                if (false) {
                    $hint = 'already paid';
                }

                $confirm = '请再次确认';
                break;
        }

        return [$visible, $hint, $confirm];
    }

    // ==== getters start ====

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpu()
    {
        return $this->hasOne(Spu::className(), ['id' => 'spu_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecifications()
    {
        return $this->hasMany(Specification::className(), ['id' => 'specification_id'])
            ->viaTable('{{%sku_specification}}', ['sku_id' => 'id']);
    }

    public function getSpecificationNames()
    {
        $specifications = $this->specifications;
        $names = [];

        if (empty($specifications)) {
            return $names;
        }

        $q = $this->getSpecifications()->joinWith('taxonomy')->select('{{%taxonomy}}.name')->orderBy([
            '{{%taxonomy}}.parent_id' => SORT_ASC,
            '{{%taxonomy}}.id' => SORT_ASC,
        ]);
        $names = ArrayHelper::getColumn($q->asArray()->all(), 'name');

        return $names;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['sku_id' => 'id']);
    }
    /**
     * @return backend\models\Price | null
     */
    public function getBasePrice()
    {
        return $this->getPrices()->joinWith(['priceGroup'])->base()->one();
    }

    /**
     * @return User|null
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
     */

    /**
     * 无需 sort 和 pagination 的 data provider
     *
    public function getItemsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => false,
            'sort' => false,
        ]);
    }
    */
    /**
     * 搭配 getItemsDataProvider() 使用，
     * 计算累计值，可用在 grid footer 内
    public function getItemsSum()
    {
        $amount = 0;

        if (empty($this->itemsDataProvider->models)) {
            return $amount;
        }
        foreach ($this->itemsDataProvider->models as $item) {
            $amount += $item->quantity;
        }

        return $amount;
        
    }
     */

    // ==== getters end ====

    /**
     * 重新组装 sku.name 列
     */
    public function reassembleName()
    {
        $slices = [
            $this->spu->brand_id ? $this->spu->brand->fullName : '',
            $this->spu->name,
            $this->spu->isStrict ? implode(' ', $this->specificationNames) : '',
        ];
        $this->name = implode(' ', $slices);

        if (!$this->save()) {
            throw new Exception('Failed to save.');
        }
    }

    // ==== event-handlers begin ====

    /**
     * 保存附件。
     *
     * 可由 self::EVENT_AFTER_INSERT, self::EVENT_UPLOAD 等触发
     *
     * @param yii\web\UploadedFile $event->data 承兑图片
    public function insertImages($event)
    {
        $images = $event->data;

        Media::store([
            'files' => $images,
            'referenceId' => $this->id,
            'type' => Media::TYPE_IMAGE,
            'category' => Media::CATEGORY_ACCEPTANCE,
            'from2to' => Mapping::ACCEPTANCE2MEDIA,
        ]);
    }
     */

    /**
     * 删除文件
     *
     * 由 self::EVENT_BEFORE_DELETE 触发
    public function deleteImages($event)
    {
        if (empty($this->images)) {
            return;
        }
        foreach ($this->images as $image) {
            if (!$image->delete()) {
                throw new Exception('Failed to flush image.');
            }
        }
    }
     */
    // ==== event-handlers end ====
}
