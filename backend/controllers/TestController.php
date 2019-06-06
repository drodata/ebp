<?php

namespace backend\controllers;

use Yii;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        print_r(Yii::$app->wem->code2session('001aUzvK1M6kR30YMOxK1JLCvK1aUzv8'));
        //print_r(Yii::$app->wem->auth);
    }

}
