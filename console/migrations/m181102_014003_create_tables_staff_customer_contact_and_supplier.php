<?php

use yii\db\Query;

/**
 * Class m181102_014003_create_tables_staff_customer_contact_and_supplier
 */
class m181102_014003_create_tables_staff_customer_contact_and_supplier extends yii\db\Migration
{
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            ['status', 1, 1, ''],
        ],
    ];

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

        // Supplier
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey()->comment('客户ID'),
            'name' => $this->string(45)->comment('姓名'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-supplier-user',
            '{{%supplier}}', 'id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // Region
        $this->createTable('{{%region}}', [
            'id' => $this->smallInteger(),
            'parent_id' => $this->smallInteger(),
            'name' => $this->string(45),
            'position' => $this->boolean()->notNull()->defaultValue(0),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-region', '{{%region}}', 'id');
        $this->addForeignKey(
            'fk-region-parent',
            '{{%region}}', 'parent_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // Contract
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey()->comment('客户ID'),
            'category' => $this->boolean()->notNull(),
            'is_lite' => $this->boolean()->notNull()->defaultValue(1),
            'is_main' => $this->boolean()->notNull()->defaultValue(0),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'user_id' => $this->integer()->null(),
            'province_id' => $this->smallInteger()->null(),
            'city_id' => $this->smallInteger()->null(),
            'district_id' => $this->smallInteger()->null(),
            'name' => $this->string(45)->notNull()->comment('姓名'),
            'phone' => $this->string(20)->notNull()->comment('手机'),
            'address' => $this->string(100)->notNull()->comment('地址'),
            'alias' => $this->string(10)->null()->comment('别称'),
            'note' => $this->string(50)->null()->comment('备注'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-contact-user',
            '{{%contact}}', 'user_id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-province-region',
            '{{%contact}}', 'province_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-city-region',
            '{{%contact}}', 'city_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-district-region',
            '{{%contact}}', 'district_id',
            '{{%region}}', 'id',
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

        // supplier
        $this->dropForeignKey('fk-supplier-user', '{{%supplier}}');
        $this->dropTable('{{%supplier}}');

        // contact
        $this->dropForeignKey('fk-district-region', '{{%contact}}');
        $this->dropForeignKey('fk-city-region', '{{%contact}}');
        $this->dropForeignKey('fk-province-region', '{{%contact}}');
        $this->dropForeignKey('fk-contact-user', '{{%contact}}');
        $this->dropTable('{{%contact}}');

        // region
        $this->dropForeignKey('fk-region-parent', '{{%region}}');
        $this->dropTable('{{%region}}');

    }
}
