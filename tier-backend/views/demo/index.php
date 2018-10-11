<?php
use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];

?>
<div class="col-sm-12">
<?php
Box::begin([
    'title' => $this->title,
    'tools' => [
        Html::a(Html::icon('plus'), '', ['class' => 'btn btn-sm btn-primary']),
    ],
]);
?>

<?php Box::end();?></div>
