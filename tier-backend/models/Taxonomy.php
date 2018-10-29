<?php

namespace backend\models;

Use Yii;

class Taxonomy extends \drodata\models\Taxonomy
{
    const TYPE_SPU_PROPERTY = 'spu-property';
    const TYPE_SPU_SPECIFICATION = 'spu-specification';

    public function init()
    {
        parent::init();

        // 商品规格修改后重新组装商品名称
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'reassembleSkuName']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['taxonomy_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecifications()
    {
        return $this->hasMany(Specification::className(), ['taxonomy_id' => 'id']);
    }

    public function getIsSpuProperty()
    {
        return $this->type == self::TYPE_SPU_PROPERTY;
    }
    public function getIsSpuSpecification()
    {
        return $this->type == self::TYPE_SPU_SPECIFICATION;
    }

    /**
     * @inheritdoc
     */
    public function getHardDeleteHint()
    {
        switch ($this->type) {
            case self::TYPE_SPU_PROPERTY:
                return $this->properties ? '有商品使用了此属性，无法删除' : null;
                break;
            case self::TYPE_SPU_SPECIFICATION:
                return $this->specifications ? '有商品使用了此规格，无法删除' : null;
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * 返回名下所有关联的 skus
     *
     * @return Sku[]|[]
     */
    public function getSkus()
    {
        return Sku::find()->joinWith(['specifications.taxonomy'])->where(['{{%taxonomy}}.id' => $this->id])->all();
    }

    /**
     * ‘spu-specification' 改变后需要同步 sku.name
     */
    public function reassembleSkuName($event)
    {
        if (!$this->isSpuSpecification) {
            return;
        }
        if (empty($this->skus)) {
            return;
        }

        foreach ($this->skus as $sku) {
            $sku->reassembleName();
        }
    }
}
