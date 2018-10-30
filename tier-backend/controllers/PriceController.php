<?php

namespace backend\controllers;

use Yii;
use backend\models\Price;
use backend\models\PriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * PriceController implements the CRUD actions for Price model.
 */
class PriceController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            // put standalone actions configuration here
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['xxx'], // 禁止访问的放在最前面
                        'allow' => false,
                    ],
                    [
                        //'actions' => ['create', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the Price model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $sku_id
     * @param integer $price_group_id
     * @param integer $threshold
     * @return Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($sku_id, $price_group_id, $threshold)
    {
        if (($model = Price::findOne(['sku_id' => $sku_id, 'price_group_id' => $price_group_id, 'threshold' => $threshold])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Price models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Price model.
     * @param integer $sku_id
     * @param integer $price_group_id
     * @param integer $threshold
     * @return mixed
     */
    public function actionView($sku_id, $price_group_id, $threshold)
    {
        return $this->render('view', [
            'model' => $this->findModel($sku_id, $price_group_id, $threshold),
        ]);
    }

    /**
     * View a record in modal
     *
     * @param integer $sku_id
     * @param integer $price_group_id
     * @param integer $threshold
     */
    public function actionModalView($sku_id, $price_group_id, $threshold)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-view', [
            'model' => $this->findModel($sku_id, $price_group_id, $threshold),
        ]);

    }

    /**
     * 在 Modal 内高级搜索
     */
    public function actionModalSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-search', [
            'model' => new PriceSearch(),
        ]);

    }

    /**
     * Creates a new Price model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Price();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '新记录已创建');
            return $this->redirect('index');
            //return $this->redirect(['view', 'sku_id' => $model->sku_id, 'price_group_id' => $model->price_group_id, 'threshold' => $model->threshold]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Price model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $sku_id
     * @param integer $price_group_id
     * @param integer $threshold
     * @return mixed
     */
    public function actionUpdate($sku_id, $price_group_id, $threshold)
    {
        $model = $this->findModel($sku_id, $price_group_id, $threshold);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '修改已保存');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Price model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $sku_id
     * @param integer $price_group_id
     * @param integer $threshold
     * @return mixed
     */
    public function actionDelete($sku_id, $price_group_id, $threshold)
    {
        $this->findModel($sku_id, $price_group_id, $threshold)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(Yii::$app->request->referrer);
    }
}
