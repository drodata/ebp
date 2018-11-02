<?php
/**
 */
namespace backend\models;

use Yii;
use yii\web\UploadedFile;

class CommonForm extends \yii\base\Model
{
    public $name;

    /* 产品规格下拉菜单 */
    public $specifications;

    public $roles;

    const SCENARIO_DEMO = 'demo';
    const SCENARIO_SPU = 'spu';
    const SCENARIO_RBAC = 'rbac';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => self::SCENARIO_DEMO],
            [['name'], 'validateAmount', 'on' => self::SCENARIO_DEMO],

            [['specifications'], 'required', 'on' => self::SCENARIO_SPU],

            [['roles'], 'required', 'on' => self::SCENARIO_RBAC],

        ];
    }
    /**
     */
    public function validateAmount($attribute, $params, $validator)
    {
        $this->addError($attribute, "error msg");
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '姓名',
            'specifications' => '产品规格',
            'roles' => '角色',
        ];
    }

    public function getRolesList()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();

        if (empty($roles)) {
            return [];
        }

        $list = [];
        foreach ($roles as $role) {
            /* @var $role yii\rbac\Role */
            $list[$role->name] = $role->description;
        }

        return $list;
    }
}
