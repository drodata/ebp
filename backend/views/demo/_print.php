<?php
use drodata\helpers\Html;
use drodata\widgets\Box;
use drodata\jqprint\PrintAsset;
use drodata\models\Lookup;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use backend\models\CommonForm;

/* @var $this yii\web\View */
/* @var $name string  */

?>
<div class="container general-print-container visible-print-block">
    <table class="table table-print table-bordered">
        <thead>
            <tr>
                <th>姓名</th>
                <th class="text-right"><?= $name ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>测试</td>
                <td class="text-right">3300.00</td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-6">
            <h3 class="text-right text-danger">发件人信息</h3>
            <p>你好</p>
        </div>
        <div class="col-xs-6">
            <h3 class="text-right text-danger">收件人信息</h3>
            <p>你好</p>
        </div>
    </div>
</div>
