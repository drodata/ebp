<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Sku */

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
            <th><?= $model->getAttributeLabel('spu_id')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('spu_id')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('name')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('name')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('status')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('status')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('visible')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('visible')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('stock')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('stock')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('threshold')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('threshold')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('description')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('description')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('introduction')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('introduction')?></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>

<?= $this->render('_list-action', ['model' => $model]) ?>
