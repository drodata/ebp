<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use backend\models\Sku;

class SkuController extends ActiveController
{
    public $modelClass = 'backend\models\Sku';

    public function actionIndex()
    {
        $query = Sku::find()->joinWith(['spu']);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [],
        ]);
    }
}
