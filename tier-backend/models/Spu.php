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
 * This is the model class for table "spu".
 * 
 * @property integer $id
 * @property integer $mode
 * @property integer $type
 * @property string $name
 * @property integer $status
 * @property integer $visible
 * @property integer $brand_id
 * @property string $description
 * @property string $introduction
 *
 * @property Property[] $properties
 * @property Sku[] $skus
 * @property Brand $brand
 */
class Spu extends \drodata\db\ActiveRecord
{
    const MODE_SIMPLE = 1;
    const MODE_STRICT = 2;

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
        return 'spu';
    }


    /**
     * @inheritdoc
     * @return SpuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpuQuery(get_called_class());
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
                    'mode' => ['spu-mode', [ ]],
                    'type' => ['spu-type', [ ]],
                    'visible' => ['boolean', [ ]],
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

            [['mode', 'type', 'name', 'status'], 'required'],
            [['mode', 'type', 'status', 'visible', 'brand_id'], 'integer'],
            [['introduction'], 'string'],
            [['name', 'description'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'mode' => '模式',
            'type' => '类别',
            'name' => '名称',
            'status' => '状态',
            'visible' => 'Visible',
            'brand_id' => '品牌',
            'description' => '简介',
            'introduction' => '详细介绍',
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
    protected function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/spu/$action", 'id' => $this->id];

        switch ($action) {
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                break;
            case 'upload-image':
                $route = ["/spu/image", 'do' => 'create', 'id' => $this->id];
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
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['spu_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkus()
    {
        return $this->hasMany(Sku::className(), ['spu_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Attachment::className(), ['id' => 'attachment_id'])
            ->viaTable('{{%spu_image}}', ['spu_id' => 'id']);
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

    /**
     * 判断产品是否为简单模式
     * @return bool
     */
    public function getIsSimple()
    {
        return $this->mode == self::MODE_SIMPLE;
    }
    /**
     * 判断产品是否为复杂模式
     * @return bool
     */
    public function getIsStrict()
    {
        return $this->mode == self::MODE_STRICT;
    }

    public function getUploadViewParams($action)
    {
        switch ($action) {
            case 'image':
                return [
                    'label' => '产品图片',
                    'subtitle' => $this->name,
                    'redirectRoute' => ['/spu/image', 'do' => 'manage', 'id' => $this->id],
                    'navigationLinks' => [
                        $this->actionLink('upload-image', ['type' => 'button', 'title' => '继续上传图片']),
                    ],
                    'dataProvider' => $this->getDataProvider($action),
                ];
                break;
        }
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

    /**
     * 根据属性名到规格名的映射
       
       ```
       [
           3 => [5, 7],
           4 => [8, 9],
       ]
       ```
       
       to
       
       ```
       [
           [5, 8],
           [5, 9],
           [7, 8],
           [7, 9],
       ]
       ```
     */
    public static function buildArray($map)
    {
        $ids = [];
        foreach ($map as $property => $specifications) {
            $ids[] = $specifications;
        }

        $base = $ids[0];
        for ($i = 1; $i < count($ids); $i++) {
            $base = static::combine($base, $ids[$i]);
        }

        $final = [];
        foreach ($base as $chain) {
            $temp = explode('_', $chain);
            $final[] = array_map('intval', $temp); 
        }

        return $final;
    }
    /**
     * @param array $master
     * @param array $slave
     */
    public static function combine($masterItems, $slaveItems)
    {
        $slices = [];
        foreach ($masterItems as $masterItem) {
            foreach ($slaveItems as $slaveItem) {
                $slices[] = $masterItem . '_' . $slaveItem;
            }
        } 
        return $slices;
    }

    /**
     * AJAX 提交表单逻辑代码
     *
     */
    public static function ajaxSubmit($post)
    {
        $d['status'] = true;

        $model = empty($post['Spu']['id']) ? new Spu() : Spu::findOne($post['Spu']['id']);
        $model->load($post);

        $properties = $post['properties'];

        // 根据属性 ids 判断模式
        $model->mode = empty($properties) ? self::MODE_SIMPLE : self::MODE_STRICT;

        $d['status'] = $model->validate() && $d['status'];
        if (!$model->validate()) {
            $d['errors']['spu'] = $model->getErrors();
        }

        // 验证规格
        if (!empty($properties)) {
            $items = [];
            foreach ($post['CommonForm'] as $index => $item) {
                $items[$index] = new CommonForm(['scenario' => CommonForm::SCENARIO_SPU]);
            }
            CommonForm::loadMultiple($items, $post);
            foreach ($post['CommonForm'] as $index => $item) {
                $d['status'] = $items[$index]->validate() && $d['status'];
                if (!$items[$index]->validate()) {
                    $key = "commonform-$index";
                    $d['errors'][$key] = $items[$index]->getErrors();
                }
            }
        }

        // all data is safe, start to submit 
        if ($d['status']) {
            if (empty($properties)) {
                // simple spu mode
                $model->on(self::EVENT_AFTER_INSERT, [$model, 'insertSku']);
            } else {
                // strict spu mode
                $slices = [];
                foreach ($items as $index => $item) {
                    $slices[$index] = $item->specifications;
                }
                $map = static::buildArray($slices);

                $model->on(self::EVENT_AFTER_INSERT, [$model, 'insertSkus'], ['map' => $map]);
            }

            if (!$model->save()) {
                throw new \yii\db\Exception($model->stringifyErrors());
            }
            $d['message'] = Html::tag('span', Html::icon('check') . '已保存', [
                'class' => 'text-success',
            ]);
            $d['redirectUrl'] = Url::to(['/sku/index']);
        }

        return $d;

    }

    /**
     * 调整产品规格（不改变产品属性的前提下）
     */
    public function adjustSpecification($generalForms)
    {
        $slices = [];
        foreach ($generalForms as $index => $item) {
            $slices[$index] = $item->specifications;
        }
        $map = static::buildArray($slices);
        $oldMap = $this->getOldMap();

        $newMap = [];
        foreach ($map as $ids) {
            if (!in_array($ids, $oldMap)) {
                $newMap[] = $ids;
            }
        }

        $event = new \yii\base\Event([
            'data' => [
                'map' => $newMap,
            ],
        ]);

        $this->insertSkus($event);
    }

    /**
     * 返回旧的规格映射
     */
    protected function getOldMap()
    {
        $slices = [];

        foreach ($this->properties as $prop) {
            $generalForms[$prop->taxonomy_id] = $generalForm;
            $slices[$prop->taxonomy_id] = $prop->specificationIds;
        }

        // 确保严格按照 taxonomy 排序
        ksort($slices);
        
        return static::buildArray($slices);
    }

    /**
     * simple mode 下保存 sku
     */
    public function insertSku($event)
    {
        $sku = new Sku([
            'spu_id' => $this->id,
            'name' => $this->name,
        ]);
        if (!$sku->save()) {
            throw new \yii\db\Exception('Failed to insert.');
        }
    }

    /**
     * 写入复杂模式下的 skus
     *
     * @param array $event->data
     * - 'map': array, 
     *
     * ```
     * [
     *     [3, 5],
     *     [3, 6],
     *     [4, 5],
     *     [4, 6],
     * ]
     * ```
     * 
     * 数组的个数表示应该创建几个 skus, 每个元素又是数组，里面包含 taxonomy ids, 即属性值的 ids
     */
    public function insertSkus($event)
    {
        $map = $event->data['map'];

        $map = static::nameIds2valueIds($this->id, $map);

        for ($i = 0; $i < count($map); $i++) {
            $sku = new Sku([
                'spu_id' => $this->id,
            ]);
            $sku->name = Specification::assembleTail($map[$i]) . $this->name;
            if (!$sku->save()) {
                throw new \yii\db\Exception('Failed to insert.');
            }

            foreach ($map[$i] as $specificationId) {
                $skuSpec = new SkuSpecification([
                    'sku_id' => $sku->id,
                    'specification_id' => $specificationId,
                ]);
                if (!$skuSpec->save()) {
                    throw new \yii\db\Exception('Failed to insert.');
                }
            }
        }
    }

    /**
     * 规格名称 ids (taxonomy) 转换成 规格值 ids (specification)
     *
     * ```
     * [
     *     [3, 5],
     *     [3, 6],
     *     [4, 5],
     *     [4, 6],
     * ]
     * ```
     * 
     * 数组的个数表示应该创建几个 skus, 每个元素又是数组，里面包含 specification ids, 
     */
    public static function nameIds2valueIds($spuId, $map)
    {
        $newMap = [];
        foreach ($map as $id => $specNameIds) {
            $valueIds = [];
            foreach ($specNameIds as $specNameId) {
                $specName = Taxonomy::findOne($specNameId);
                $property = Property::fetch($spuId, $specName->parent_id);
                $spec = Specification::fetch($property->id, $specName->id);
                $valueIds[] = $spec->id;
            }
            $newMap[] = $valueIds;
        }

        return $newMap;
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
