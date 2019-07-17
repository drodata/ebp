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

        $this->on(self::EVENT_AFTER_INSERT, [$this, 'initPrice']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteImages']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'deletePrice']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteSkuSpecifications']);
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
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['stock'], $fields['threshold'], $fields['status'], $fields['visible']);

        return ArrayHelper::merge($fields, [
            'uprice' => function ($model) {
                return $model->price->value;
            },
            'imageUrls' => function ($model) {
                return $model->getImageUrls();
            }
        ]);
    }
    public function extraFields()
    {
        return ['spu', 'price'];
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
            'id' => '商品编号',
            'spu_id' => 'Spu ID',
            'name' => '商品名称',
            'status' => '状态',
            'visible' => 'Visible',
            'stock' => '库存',
            'threshold' => '库存预警值',
            'description' => '简介',
            'introduction' => '详细介绍',
        ];
    }

    /**
     * 反回操作链接。需要自行实现 getActionOptions()
     * 
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
     * 返回 $action 常见的选项
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 三个元素依次表示：按钮可见性、禁用提示和确认提示
     *
     */
    protected function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/sku/$action", 'id' => $this->id];

        switch ($action) {
            case 'view':
                $options = [
                    'title' => '详情',
                    'icon' => 'eye',
                    'class' => 'modal-view',
                ];
                break;
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                break;
            case 'upload-image':
                $route = ["/sku/image", 'do' => 'create', 'id' => $this->id];
                $options = [
                    'title' => '上传图片',
                    'icon' => 'upload',
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
                if ($this->spu->isStrict) {
                    $hint = '严格模式商品无法删除，只能隐藏或下架';
                }
                break;
            case 'adjust-price':
                $route = ["/price/batch-update", 'scenario' => 'sku', 'id' => $this->id];
                $options = [
                    'title' => '调整价格',
                    'icon' => 'rmb',
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
    public function getSpu()
    {
        return $this->hasOne(Spu::className(), ['id' => 'spu_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkuSpecifications()
    {
        return $this->hasMany(SkuSpecification::className(), ['sku_id' => 'id']);
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
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['sku_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Attachment::className(), ['id' => 'attachment_id'])
            ->viaTable('{{%sku_image}}', ['sku_id' => 'id']);
    }
    /**
     * @return Attachment
     */
    public function getImage()
    {
        return $this->getImages()->one();
    }

    /**
     * 返回常用的 DP
     */
    public function getDataProvider($key)
    {
        switch ($key) {
            case 'image':
                $query = $this->getImages();
                break;
        }

        return new ActiveDataProvider([
            'query' => $query,
			'pagination' => false,
			'sort' => false,
        ]);
    }
    public function getUploadViewParams($action)
    {
        switch ($action) {
            case 'image':
                return [
                    'label' => '商品图片',
                    'subtitle' => $this->name,
                    'redirectRoute' => ['/sku/image', 'do' => 'manage', 'id' => $this->id],
                    'navigationLinks' => [
                        $this->actionLink('upload-image', ['type' => 'button', 'title' => '继续上传图片']),
                        Lookup::navigationLink('sku', ['type' => 'button']),
                    ],
                    'dataProvider' => $this->getDataProvider($action),
                ];
                break;
        }
    }

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

    /**
     *
     */
    public function getThumbnail()
    {
        if ($this->image) {
            return $this->image->thumbnail;
        }
        if ($this->spu->image) {
            return $this->spu->image->thumbnail;
        }

        return Attachment::defaultThumbnail();
    }

    public function getImageUrls($size = 'o')
    {
        if (empty($this->images)) {
            return $this->spu->getImageUrls($size);
        }

        $urls = [];
        foreach ($this->images as $image) {
            $urls[] = $image->getUrl($size);
        }

        return $urls;
    }
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
     * Init price
     *
     * Triggered by self::EVENT_AFTER_INSERT
     *
     */
    public function initPrice($event)
    {
        $price = new Price(['sku_id' => $this->id]);

        if (!$price->save()) {
            throw new Exception($price->stringifyErrors());
        }
    }

    /**
     * 删除关联 price. 由 self::EVENT_BEFORE_DELETE 触发
     */
    public function deletePrice($event)
    {
        if (empty($this->price)) {
            return;
        }
        if (!$this->price->delete()) {
            throw new Exception('Failed to delete.');
        }
    }
    /**
     * 删除商品图片. 由 self::EVENT_BEFORE_DELETE 触发
     */
    public function deleteImages($event)
    {
        if (empty($this->images)) {
            return;
        }
        foreach ($this->images as $item) {
            /* @var Attachment $item */
            if (!$item->delete()) {
                throw new Exception('Failed to delete.');
            }
        }
    }
    /**
     * 删除 sku_specification records. 由 self::EVENT_BEFORE_DELETE 触发
     */
    public function deleteSkuSpecifications($event)
    {
        if (empty($this->skuSpecifications)) {
            return;
        }
        foreach ($this->skuSpecifications as $item) {
            /* @var SkuSpecification $item */
            if (!$item->delete()) {
                throw new Exception('Failed to delete.');
            }
        }
    }
    // ==== event-handlers end ====
}
