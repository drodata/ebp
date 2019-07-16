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

    public function actions()
    {
        $actions = parent::actions();
    
        // disable the "delete" and "create" actions
        //unset($actions['delete'], $actions['create']);
    
        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        /**
         * Uncomment to add your own standalone actions.
         *
        $actions['create'] = [
            'class' => 'api\actions\BrandCreateAction',
        ];
        */
    
        return $actions;
    }

    /**
     * 覆盖默认的 index action dataprovider
     */
    public function prepareDataProvider()
    {
        $query = Sku::find()->groupBy('spu_id');
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
