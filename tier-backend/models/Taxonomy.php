<?php

namespace backend\models;

Use Yii;

class Taxonomy extends \drodata\models\Taxonomy
{
    public function init()
    {
        parent::init();

        // 商品规格修改后重新组装商品名称
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'reassembleSkuName']);
    }

    const TYPE_SPU_SPECIFICATION = 'spu-specification';

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropeties()
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

    public function getIsSpuSpecification()
    {
        return $this->type == self::TYPE_SPU_SPECIFICATION;
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
