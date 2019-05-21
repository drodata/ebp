<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Price;
use backend\models\PriceSearch;
use backend\models\Sku;
use yii\web\Controller;

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
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'view', 'modal-view'],
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
     * @param integer $id
     * @return Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Price::findOne($id)) !== null) {
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
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * View a record in modal
     *
     * @param integer $id
     */
    public function actionModalView($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-view', [
            'model' => $this->findModel($id),
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
     * 批量设置价格
     *
     * @param string $scenario 可用的值包括：'spu'
     * @param string $id 当 scenario 值为 'spu' 时是 spu id.
     */
    public function actionCreate($scenario, $id)
    {
        $items = [];

        switch ($scenario) {
            case 'spu':
                foreach (Sku::find()->spu($id)->all() as $sku) {
                    $items[$sku->id] = $sku->price ?: new Price(['sku_id' => $sku->id]);
                }
                $route = '/spu/';
                break;
        }

        if (Model::loadMultiple($items, Yii::$app->request->post()) && Model::validateMultiple($items)) {
            list($success, $hint) = Price::saveMultiple($items); 
            Yii::$app->session->setFlash($success ? 'success' : 'warning', $hint);

            return $this->redirect($route);
        }

        return $this->render('create', [
            'items' => $items,
        ]);
    }


    /**
     * Updates an existing Price model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * ACTION TEMPLATE. Make changes as your need.
     * Operate an existing Price model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDo($id)
    {
        if (Yii::$app->request->isGet) {
            Yii::$app->session->set('redirectUrl', Yii::$app->request->referrer);
        }

        list($success, $hint) = $this->findModel($id)->do();

        Yii::$app->session->setFlash($success ? 'success' : 'warning', $hint);

        return $this->redirect(Yii::$app->session->get('redirectUrl'));
    }
}
