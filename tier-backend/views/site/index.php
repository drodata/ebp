<?php
use common\widgets\Panel;

$this->title = 'Login';
$this->params['title'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php Panel::begin([
            "title" => $this->title,
        ]) ?>
            <span>Google</span>
        <?php Panel::end(); ?>
    </div>
</div>
