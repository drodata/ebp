<?php

use yii\db\Query;

/**
 * Class m181102_014003_create_tables_staff_and_customer
 */
class m181102_014003_create_tables_staff_and_customer extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Staff
        $this->createTable('{{%staff}}', [
            'id' => $this->primaryKey()->comment('工号'),
            'name' => $this->string(45)->comment('姓名'),
            'shop_id' => $this->integer()->notNull()->comment('所属店铺'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-staff-user',
            '{{%staff}}', 'id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-staff-shop',
            '{{%staff}}', 'shop_id',
            '{{%shop}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // Customer
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey()->comment('客户ID'),
            'name' => $this->string(45)->comment('姓名'),
            // 1 是系统内置的初始分组
            'price_group_id' => $this->integer()->notNull()->comment('价格分组')->defaultValue(1),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-customer-user',
            '{{%customer}}', 'id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-customer-price_group',
            '{{%customer}}', 'price_group_id',
            '{{%price_group}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // staff
        $this->dropForeignKey('fk-staff-shop', '{{%staff}}');
        $this->dropForeignKey('fk-staff-user', '{{%staff}}');
        $this->dropTable('{{%staff}}');

        // customer
        $this->dropForeignKey('fk-customer-price_group', '{{%customer}}');
        $this->dropForeignKey('fk-customer-user', '{{%customer}}');
        $this->dropTable('{{%customer}}');
    }
}
