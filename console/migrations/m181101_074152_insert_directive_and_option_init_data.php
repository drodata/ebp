<?php

use yii\db\Query;

/**
 * 初始化常用指令符
 */
class m181101_074152_insert_directive_and_option_init_data extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%directive}}', ['scope', 'category', 'code', 'name', 'format', 'description'], [
            ['app', null, 'enableMultipleShop', '多店铺开关', 'boolean', '适合有多个门店的场景'],
            ['shop', null, 'enablePriceGroup', '价格分组开关', 'boolean', '不同的用户指定设定不同的价格折扣，适合老客户或批发场景'],
        ]);
        $this->batchInsert(
            '{{%option}}',
            ['directive_code', 'value', 'user_id', 'shop_id'],
            [
                ['enableMultipleShop', 0, null, null],

                // shop ID: 1 是默认的店铺
                ['enablePriceGroup', 0, null, 1],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*
        $this->dropForeignKey('fk-order-customer', '{{%TABLE}}');
        $this->dropTable('{{%TABLE}}');
        $this->dropColumn('{{%TABLE}}', 'stock_status');

        $this->delete('{{%lookup}}', ['type' => ['Status']]);
        */

        echo "m181101_074152_insert_directive_and_option_init_data cannot be reverted.\n";

        return false;

    }

}
