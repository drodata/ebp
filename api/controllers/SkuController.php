<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use backend\models\Sku;

class SkuController extends ActiveController
{
    public $modelClass = 'backend\models\Sku';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['auth'] = ['class' => QueryParamAuth::className()];
        unset($behaviors['contentNegotiator']['formats']['application/xml']);

        return $behaviors;
    }

    public function actionIndex()
    {
        $query = Sku::find()->joinWith(['spu']);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [],
        ]);
    }
}
