<?php

use yii\db\Migration;

/**
 * Class m171229_132303_creata_demo_tables
 * 
 * 本 Migration 主要起演示作用
 */
class m171229_132303_creata_demo_tables extends Migration
{
    // 要写入的字典条目，用于 batchInsert()
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            ['OrderPaymentWay', 1, 1, '微信'],
            ['OrderPaymentWay', 2, 2, '支付宝'],
            ['OrderPaymentWay', 3, 3, '现金'],
        ],
    ];
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('order', [
			'id' => $this->bigPrimaryKey(),
            'payment_way' => $this->boolean()->notNull(),
            'note' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        $this->createTable('goods', [
			'id' => $this->bigPrimaryKey(),
            'order_id' => $this->bigInteger()->notNull(),
            'name' => $this->smallInteger(3)->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey(
            'fk-goods-order',
            'goods', 'order_id',
            'order', 'id',
            'NO ACTION', 'NO ACTION'
        );

        $this->batchInsert('lookup', $this->lookups[0], $this->lookups[1]);
    }

    public function safeDown()
    {
		$this->dropForeignKey('fk-goods-order', 'goods');
		$this->dropTable('goods');
		$this->dropTable('order');

        $this->delete('lookup', ['type' => ['OrderPaymentWay']]);
    }
}
