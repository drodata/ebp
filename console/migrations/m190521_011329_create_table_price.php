<?php

use yii\db\Query;

/**
 * Class m190521_011329_create_table_price
 */
class m190521_011329_create_table_price extends yii\db\Migration
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
        $this->createTable('{{%price}}', [
            'id' => $this->bigPrimaryKey(),
            'sku_id' => $this->bigInteger()->notNull()->comment('商品编号'),
            'value' => $this->decimal(10,2)->comment('单价'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-price-sku',
            '{{%price}}', 'sku_id',
            '{{%sku}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-price-sku', '{{%price}}');
        $this->dropTable('{{%price}}');
    }
}
