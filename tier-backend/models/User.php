<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Exception;

/**
 */
class User extends \drodata\models\User
{
    const SCENARIO_STAFF = 'staff';

    public function init()
    {
        parent::init();
    }

    public function rules()
    {
        $rules = [
            ['status', 'default', 'value' => 1],

            ['status', 'safe', 'on' => self::SCENARIO_STAFF],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * 返回角色名称列表
     *
     * @return string[]
     */
    public function getRoleNames()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (empty($roles)) {
            return [];
        }

        $names = [];
        foreach ($roles as $role) {
            $names[] = $role->name;
        }

        return $names;
    }

    /**
     * 新建员工
     */
    public function insertStaff($event)
    {
        $staff = new Staff([
            'id' => $this->id,
            'name' => $this->username,
            'shop_id' => 1,
        ]);

        if (!$staff->save()) {
            throw new Exception($staff->stringifyErrors());
        }
    }

    /**
     * 分配角色
     *
     * @param $event->data string[] role names
     */
    public function assignRoles($event)
    {
        $auth = Yii::$app->authManager;

        if (!$this->isNewRecord) {
            $auth->revokeAll($this->id);
        }

        foreach ($event->data as $roleName) {
            $role = $auth->getRole($roleName);
            $auth->assign($role, $this->id);
        };
    }
}
