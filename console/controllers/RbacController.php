<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\rbac\OwnerRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $staff = $auth->createRole('staff');
        $staff->description = 'Staff';
        $auth->add($staff);

        // Permissions
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create an user';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update an user';
        $auth->add($updateUser);

        // Hierarchy
        $auth->addChild($admin, $staff);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);


        // Rule
        $ownerRule = new OwnerRule;
        $auth->add($ownerRule);
        
        // add the "updateOwnAccount" permission and associate the rule with it.
        $updateOwnAccount = $auth->createPermission('updateOwnAccount');
        $updateOwnAccount->description = 'Update own account';
        $updateOwnAccount->ruleName = $ownerRule->name;
        $auth->add($updateOwnAccount);

        // "updateOwnAccount" will be used from "updateUser"
        $auth->addChild($updateOwnAccount, $updateUser); 
        
        // allow "staff" to update their own account
        $auth->addChild($staff, $updateOwnAccount);

        // Assignment
        $auth->assign($admin, 1);
    }

    public function actionFlush()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
