<?php

namespace backend\controllers;

use Yii;
use backend\models\CommonForm;
use backend\models\Sku;
use backend\models\SkuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SkuController implements the CRUD actions for Sku model.
 */
class SkuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'image' => [
                'class' => 'dro\attachment\UploadAction',
                'modelClass' => 'backend\models\Sku',
                'uploadFormClass' => 'backend\models\UploadForm',
            ],
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
     * Finds the Sku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Sku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sku model.
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
            'model' => new SkuSearch(),
        ]);

    }

    /**
     * Creates a new Sku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sku();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '新记录已创建');
            return $this->redirect('index');
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * AJAX 提交表单
     */
    public function actionAjaxSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Sku::ajaxSubmit($_POST);
    }

    /**
     * Updates an existing Sku model.
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
     * Deletes an existing Sku model.
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
     * 为 Sku 模型上传附件 
     * @param integer $id
     * @return mixed
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);
        // 根据需要修改场景值
        $common = new CommonForm(['scenario' => CommonForm::SCENARIO_XXX]);

        if ($common->load(Yii::$app->request->post())) {
            $common->images = UploadedFile::getInstances($common, 'images');
            if ($common->validate()) {
                $model->on(Sku::EVENT_UPLOAD, [$model, 'insertImages'], $common->images);
                $model->trigger(Sku::EVENT_UPLOAD);
                Yii::$app->session->setFlash('success', '图片已上传。');

                return $this->redirect('index');
            }
        }

        return $this->render('upload', [
            'model' => $model,
            'common' => $common,
        ]);
    }
}
