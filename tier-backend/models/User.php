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

    /**
     * key means scenario names
     */
    public function transactions()
    {
        return ArrayHelper::merge(parent::rules(), [
            self::SCENARIO_STAFF => self::OP_ALL,
        ]);
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
}
