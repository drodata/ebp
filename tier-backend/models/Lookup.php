<?php

namespace backend\models;

use Yii;
use drodata\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;

/**
 * 各个视图内引用的此类而非 drodata\models\Lookup, 目的是可以在这里添加一些
 * application-specific 的静态方法。例如，可以添加一个 customers() 的静态方法，
 * 返回所有客户的 map. 这么做的好处是，不必在视图内再单独引用 Customer 类，
 * 只需引入 Lookup 类即可获取绝大多数的 map。
 */
class Lookup extends \drodata\models\Lookup
{
}
