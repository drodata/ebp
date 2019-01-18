<?php

namespace backend\models;

use Yii;
/**
 * This is the ActiveQuery class for [[Price]].
 *
 * @see Price
 */
class PriceQuery extends \yii\db\ActiveQuery
{
    public function ofSpu($id)
    {
        return $this->andWhere(['{{%sku}}.spu_id' => $id]);
    }
    /**
     * 基础价格
     */
    public function base()
    {
        return $this->andWhere(['{{%price_group}}.is_base' => 1]);
    }

    /**
     * @inheritdoc
     * @return Price[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Price|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
