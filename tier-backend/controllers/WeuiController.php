<?php

namespace backend\controllers;

class WeuiController extends \yii\web\Controller
{
    public $layout = 'weui';
    public function actionIndex()
    {
        return $this->render('index');
    }

}
