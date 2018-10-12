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
