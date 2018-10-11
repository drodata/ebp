<?php

namespace common\widgets;
use yii\helpers\Html;

class Panel extends \yii\bootstrap\Widget
{
    public $style = 'default';
    public $title = '';
    public function init()
    {
        parent::init();
        $opt  = Html::beginTag('div', ['class' => 'panel panel-' . $this->style]);
        $opt .= '<div class="panel-heading">'
             . '<div class="panel-title">'
             . $this->title
             . '</div></div>';
        $opt .= '<div class="panel-body">';

        echo $opt;
    }
    public function run()
    {
        echo '</div></div>';
    }
}
