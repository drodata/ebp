<?php

/**
 * 表格视图模板
 */

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */

use drodata\helpers\Html;
use backend\models\Lookup;
?>

<table class="table table-condensed">
    <tbody>
        <tr>
        <?php foreach ($model->items as $item): ?>
            <td class="text-center"><?= $item->id ?></td>
        <?php endforeach; ?>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>
