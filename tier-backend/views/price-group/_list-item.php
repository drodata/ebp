<?php

/* @var $this yii\web\View */
/* @var $model backend\models\PriceGroup */

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
            <th><?= $model->getAttributeLabel('currency_code')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('currency_code')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('name')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('name')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('is_base')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('is_base')?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('offset')?></th>
            <td class="text-center"><?= $model->getAttributeLabel('offset')?></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>

<?= $this->render('_list-action', ['model' => $model]) ?>
