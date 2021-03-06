<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use common\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'backend\models\User';

    public function actionIndex()
    {
        $query = User::find()->joinWith(['group']);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [],
        ]);
    }
}
