<?php

use yii\db\Query;

/**
 * Class m181101_073047_create_table_shop
 */
class m181101_073047_create_table_shop extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull()->comment('店铺名称'),
        ], $this->tableOptions);

        $this->insert('{{%shop}}', ['name' => '我的店铺']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop}}');
    }

}
