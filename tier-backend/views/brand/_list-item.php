<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */

use drodata\helpers\Html;
use backend\models\Lookup;
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th><?= $model->getAttributeLabel('id')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('id')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('name')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('name')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('alias')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('alias')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('visible')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('visible')?></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>

<?= $this->render('_list-action', ['model' => $model]) ?>
