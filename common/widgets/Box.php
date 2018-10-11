<?php

namespace common\widgets;
use yii\helpers\Html;

class Box extends \yii\bootstrap\Widget
{
    public $style = 'default';
    public $solid = false;
    public $title = '';
    public $footer = null;
    public function init()
    {
        parent::init();
        
        $boxClassNames = ['box'];
        $boxClassNames[] = 'box-' . $this->style;
        if ($this->solid) {
            $boxClassNames[] = 'box-solid';
        }
        $opt  = Html::beginTag('div', ['class' => implode(' ', $boxClassNames)]);

        // header
        $opt  .= Html::beginTag('div', ['class' => 'box-header with-border']);
        $opt  .= Html::tag('h3', $this->title, ['class' => 'box-title']);
        $opt  .= Html::endTag('div');

        // body
        $opt  .= Html::beginTag('div', ['class' => 'box-body']);

        echo $opt;
    }
    public function run()
    {
        $tail = Html::endTag('div'); // .box-body 
        if (!empty($this->footer)) {
            $tail  .= Html::tag('div', $this->footer, ['class' => 'box-footer']);
        }
        $tail .= Html::endTag('div'); // .box ends

        echo $tail;
    }
}
