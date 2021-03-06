<?php

namespace backend\models;

use Yii;
/**
 * This is the ActiveQuery class for [[Sku]].
 *
 * @see Sku
 */
class SkuQuery extends \yii\db\ActiveQuery
{
    public function mine()
    {
        return $this->andWhere(['{{%cash}}.created_by' => Yii::$app->user->id]);
    }

    public function spu($id)
    {
        return $this->andWhere(['{{%sku}}.spu_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return Sku[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Sku|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
