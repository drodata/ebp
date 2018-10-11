<?php
namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;

class Money extends \drodata\models\Money
{
    //const TYPE_USER = 'user';
    //const ACTION_BORROW = 'borrow';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_AFTER_INSERT, [$this, 'syncUserMoney']);
    } 
    
    /**
     * Event handlers
     *
    public function syncUserMoney($event)
    {
        $columnName = $this->is_post ? 'debt' : 'deposit';

        $user = $this->user;
        $user->{$columnName} += $this->amount;

        if (!$user->save()) {
            throw new \yii\db\Exception('Failed to save');
        }
    }
     */
}
