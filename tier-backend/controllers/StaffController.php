<?php

namespace backend\controllers;

use Yii;
use backend\models\CommonForm;
use backend\models\Staff;
use backend\models\StaffSearch;
use backend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'modal-view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
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
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staff model.
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
            'model' => new StaffSearch(),
        ]);

    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => User::SCENARIO_STAFF]);
        $common = new CommonForm(['scenario' => CommonForm::SCENARIO_RBAC]);

        if (
            $model->load(Yii::$app->request->post()) 
            && $model->validate()
            && $common->load(Yii::$app->request->post()) 
            && $common->validate()
        ) {

            $model->on(User::EVENT_BEFORE_INSERT, [$model, 'generateRandomPassword']);
            $model->on(User::EVENT_AFTER_INSERT, [$model, 'insertStaff']);
            $model->on(User::EVENT_AFTER_INSERT, [$model, 'assignRoles'], $common->roles);

            $model->save();

            Yii::$app->session->setFlash('success', '员工已创建');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'common' => $common,
        ]);
    }


    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $common = new CommonForm([
            'scenario' => CommonForm::SCENARIO_RBAC,
            'roles' => $model->user->getRoleNames(),
        ]);

        if (
            $model->load(Yii::$app->request->post()) 
            && $model->validate()
            && $common->load(Yii::$app->request->post()) 
            && $common->validate()
        ) {
            $model->on(User::EVENT_AFTER_UPDATE, [$model->user, 'assignRoles'], $common->roles);
            $model->save();

            Yii::$app->session->setFlash('success', '修改已保存');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'common' => $common,
        ]);
    }

    /**
     * Deletes an existing Staff model.
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
}
