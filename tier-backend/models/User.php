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
    const SCENARIO_CUSTOMER = 'customer';

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
            self::SCENARIO_CUSTOMER => self::OP_ALL,
        ]);
    }

    public function rules()
    {
        $rules = [
            ['status', 'default', 'value' => 1],

            ['status', 'safe', 'on' => self::SCENARIO_STAFF],
            ['status', 'safe', 'on' => self::SCENARIO_CUSTOMER],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }
    /**
     * 写入前自动生成随机密码
     *
     * Triggered by self::EVENT_BEFORE_INSERT
     */
    public function generateRandomPassword($event)
    {
        $this->setPassword(mt_rand(100000, 999999));
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
     * 新建客户
     */
    public function insertCustomer($event)
    {
        $customer = new Customer([
            'id' => $this->id,
            'name' => $this->username,
        ]);

        if (!$customer->save()) {
            throw new Exception($customer->stringifyErrors());
        }
    }
}
