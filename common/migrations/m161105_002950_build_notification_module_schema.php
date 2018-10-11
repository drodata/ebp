<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\db\Schema;
use yii\db\Query;
use yii\rbac\DbManager;

class m161105_002950_build_notification_module_schema extends Migration
{
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * Table 'message'
         */
        $this->createTable('{{message}}', [
			'id' => $this->bigPrimaryKey(),
            'category' => $this->smallInteger()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'reference_id' => $this->bigInteger(20)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey(
            'fk-msg-creator',
            '{{%message}}', 'created_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-msg-updator',
            '{{%message}}', 'updated_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        /**
         * Table 'notification'
         */
        $this->createTable('{{notification}}', [
			'id' => $this->bigPrimaryKey(),
			'message_id' => $this->bigInteger()->notNull(),
            'receiver_id' => $this->integer()->notNull(),
            'is_read' => $this->boolean()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey(
            'fk-ntf-creator',
            '{{%notification}}', 'created_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-ntf-updator',
            '{{%notification}}', 'updated_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-notification-message',
            '{{%notification}}', 'message_id',
            '{{%message}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        /**
         * Table 'comment'
         */
        $this->createTable('{{comment}}', [
			'id' => $this->bigPrimaryKey(),
            'message_id' => $this->bigInteger()->notNull(),
            'content' => $this->text()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey(
            'fk-cmt-creator',
            '{{%comment}}', 'created_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-cmt-updator',
            '{{%comment}}', 'updated_by',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-cmt-msg',
            '{{%comment}}', 'message_id',
            '{{%message}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{message}}');
        $this->dropTable('{{notification}}');
        $this->dropTable('{{comment}}');
    }
}
