<?php

namespace backend\controllers;

use Yii;
use backend\models\Map;
use backend\models\Lookup;
use backend\models\CommonForm;
use backend\models\LookupSearch;

class DemoController extends \yii\web\Controller
{
    public function actionIndex($category)
    {
        return $this->render($category);
    }
    /**
     * 管理临时产品
     */
    public function actionModalCreateProduct()
    {
        // 使用 Map 无任何实际意义，仅仅为了演示作用
        $model = new Map();
        return $this->render('modal-create-product', [
            'model' => $model,
        ]);
    }
    public function actionAjaxGetSelectModal()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('_select2-modal');
    }

    public function actionAjaxPrint()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new CommonForm(['scenario' => CommonForm::SCENARIO_DEMO]);
        $model->load(Yii::$app->request->post());

        // 为了演示提交按钮禁用效果
        sleep(3);

        return $this->renderPartial('_print', ['name' => $model->name]);
    }

    /*
     * @param string $keyword 
     */
    public function actionSearch($keyword)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $keywords = array_map('trim', explode(' ', $keyword));

        $items = Lookup::find()->where(['like', 'name', $keywords])->asArray()->all();

        return [
            'results' => $items,
        ];
    }
}
