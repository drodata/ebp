<?php

namespace backend\models;

use Yii;
/**
 * This is the ActiveQuery class for [[Customer]].
 *
 * @see Customer
 */
class CustomerQuery extends \yii\db\ActiveQuery
{
    public function mine()
    {
        return $this->andWhere(['{{%cash}}.created_by' => Yii::$app->user->id]);
    }

    /**
     * @inheritdoc
     * @return Customer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Customer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
