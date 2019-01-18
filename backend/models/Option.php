<?php
namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Option extends \drodata\models\Option
{
    /**
     * @inheritdoc
     * @return OptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OptionQuery(get_called_class());
    }
}
