<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Option]].
 *
 * @see Option
 */
class OptionQuery extends \yii\db\ActiveQuery
{
    /**
     * of scope 'app'
     */
    public function app()
    {
        return $this->andWhere(['{{%directive}}.scope' => Directive::SCOPE_APP]);
    }

    /**
     * @inheritdoc
     * @return Option[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Option|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
