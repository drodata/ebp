<?php

namespace api\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use backend\models\User;
use backend\models\WmpSession;
use common\models\LoginForm;

class SiteController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['login', 'bind-account'],
        ];

        return $behaviors;
    }

    /**
     * 登录入口
     *
     * $_POST 中包含从小程序端发送过来的参数：code
     * @return json 对象 里面包含生成的会话 id，将回传至小程序端
     */
    public function actionLogin()
    {
        $code = ArrayHelper::getValue(Yii::$app->request->getBodyParams(), 'code');
        $resp = Yii::$app->wem->code2session($code);

        return WmpSession::deploy($resp['openid']);
    }

    /**
     * 绑定员工账号
     */
    public function actionBindAccount()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());

        if (!$model->validate()) {
            $msg = '';
            foreach ($model->firstErrors as $attr => $errorMsg) {
                $msg = $errorMsg;
            }

            return [
                'status' => false,
                'msg' => $msg,
            ];
        }

        // 账号密码正确
        $user = User::findByUsername(mb_strtolower($model->username));
        Yii::$app->user->login($user);

        if (Yii::$app->user->can('saler') || Yii::$app->user->can('productionDirector')) {
        } else {
            return [
                'status' => false,
                'msg' => '目前仅支持销售人员及生产部门账号绑定，其它账号绑定会逐步开放。',
            ];
        }

        // 会话服务器 session.key 列
        $session = Yii::$app->request->post('session');
        $user->updateAttributes([
            'wma_session' => $session,
            'avatar_url' => Yii::$app->request->post('avatarUrl'),
        ]);

        return [
            'status' => true,
            'msg' => '绑定完成',
            'user' => [
                'roles' => $user->getRoles(),
                'username' => $user->username,
            ],
        ];
    }
    /**
     * 解绑员工账号
     */
    public function actionUnbind()
    {
        Yii::$app->user->identity->unbind();
        return [
            'message' => '帐号解绑成功',
        ];
    }
}
