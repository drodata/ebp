<?php

use yii\db\Query;

/**
 * 价格分组插件，包括 price_group
 *
 */
class m181029_074847_build_price_module extends yii\db\Migration
{
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            //['status', 1, 1, ''],
        ],
    ];

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_group}}', [
            'id' => $this->primaryKey()->comment('价格组编号'),
            'currency_code' => $this->string(3)->notNull()->comment('币种'),
            'name' => $this->string(45)->notNull()->comment('名称'),
            'is_base' => $this->boolean()->notNull()->comment('基础分组'),
            'discount' => $this->decimal(4,2)->comment('折扣'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-currency-code',
            '{{%price_group}}', 'currency_code',
            '{{%currency}}', 'code',
            'NO ACTION', 'NO ACTION'
        );

        $this->insert('{{%price_group}}', [
            'currency_code' => 'CNY',
            'name' => '人民币基础组',
            'is_base' => 1,
        ]);

        $this->createTable('{{%price}}', [
            'sku_id' => $this->bigInteger()->notNull()->comment('商品'),
            'price_group_id' => $this->integer()->notNull()->comment('价格分组'),
            'threshold' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Threshold'),
            'price' => $this->decimal(6,2)->notNull()->comment('单价'),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-price', '{{%price}}', ['sku_id', 'price_group_id', 'threshold']);
        $this->addForeignKey(
            'fk-price-sku',
            '{{%price}}', 'sku_id',
            '{{%sku}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-price-price_group',
            '{{%price}}', 'price_group_id',
            '{{%price_group}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-price-price_group', '{{%price}}');
        $this->dropForeignKey('fk-price-sku', '{{%price}}');
        $this->dropTable('{{%price}}');

        $this->dropForeignKey('fk-currency-code', '{{%price_group}}');
        $this->dropTable('{{%price_group}}');
    }

}
