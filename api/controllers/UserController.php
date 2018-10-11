<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use common\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }
    public function actionIndex()
    {
        $query = User::find()->joinWith(['group']);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [],
        ]);
    }
}
