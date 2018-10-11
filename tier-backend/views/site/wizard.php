<?php

/**
 * Use in controller:
 * return $this->render(
    '/site/wizard',
    'title' => '',
    'style' => '', // 'primary', 'danger' and etc.
    'content' => '',
    'center' => true,
    'buttons' => [],
   );
 */
use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var array $wizard */

$this->title = $title;
?>
<div class="row site-wizard">
    <div class="col-md-12 col-lg-6 col-lg-offset-3 text-center <?= empty($center) ? '' : 'text-center' ?>">
        <?php Box::begin([
            'title' => $title, 
            'style' => $style,
        ]);?>
            <?= $content ?>

            <div class="button-group text-center" style="margin-top:15px">
                <?= implode("\n", $buttons) ?>
            </div>

        <?php Box::end();?>
    </div>
</div>
