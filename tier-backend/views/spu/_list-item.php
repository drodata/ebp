<?php

use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Spu */
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
            <th><?= $model->getAttributeLabel('mode')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('mode')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('type')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('type')?></td>
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
            <th><?= $model->getAttributeLabel('brand_id')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('brand_id')?></td>
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
