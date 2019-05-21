<?php
/* @var $this yii\web\View */
/* @var $form yii\bootatrap\ActiveForm */
/* @var $items Price[]  */

use drodata\helpers\Html;
use backend\models\Lookup;
?>

<table class="table table-condensed">
    <thead>
        <tr>
            <th>品名</th>
            <th>单价</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($items as $token => $item): ?>
    <tr class="itemRow" data-key="<?= $token ?>">
        <td><?= $item->sku->name ?></td>
        <td>
            <?= $form->field($item, "[$token]value")->label(false)->input('number', ['step' => 0.01]) ?>
        </td>
        <td>
            <?= $form->field($item, "[$token]sku_id")->label(false)->hiddenInput() ?>
        </td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>
