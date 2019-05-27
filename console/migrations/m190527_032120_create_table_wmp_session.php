<?php

use yii\db\Query;

/**
 * Class m190527_032120_create_table_wmp_session
 */
class m190527_032120_create_table_wmp_session extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wmp_session}}', [
            'open_id' => $this->string(100)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'value' => $this->string(100)->notNull(),
            'expires_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        $this->addPrimaryKey('pk-user-openid', '{{%wmp_session}}', ['open_id', 'user_id']);
        $this->addForeignKey(
            'fk-wmp_session-user',
            '{{%wmp_session}}', 'user_id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-wmp_session-user', '{{%wmp_session}}');
        $this->dropTable('{{%wmp_session}}');
    }
}
