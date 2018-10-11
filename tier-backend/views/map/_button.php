<?php

/* operation button row */

/* @var $this yii\web\View */
?>

<?php if(!empty($this->params['buttons'])): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="button-area" style="padding-bottom:10px;">
            <?= implode("\n", $this->params['buttons']) ?>
        </div>
    </div>
</div>
<?php endif; ?>
