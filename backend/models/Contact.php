<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Exception;

/**
 */
class Contact extends \drodata\models\Contact
{
    const CATEGORY_CUSTOMER = 1;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'user_id']);
    }
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'user_id']);
    }

    /**
     * 通用新建修改操作视图中的参数
     * @return array indexed
     */
    public function getViewParams()
    {
        switch ($this->category) {
            case self::CATEGORY_CUSTOMER:
                return [
                    '客户联系方式', //label
                    "{$this->customer->name}", //subtitle
                    '/customer', //redirectRoute
                ];
                break;
        }
    }
}
