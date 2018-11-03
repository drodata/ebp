<?php

use yii\db\Query;

/**
 * Class m181101_073603_add_column_shop_id_to_table_option
 */
class m181101_073603_add_column_shop_id_to_table_option extends yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%option}}', 'shop_id', $this->integer()->null()->after('user_id'));
        $this->addForeignKey(
            'fk-option-shop',
            '{{%option}}', 'shop_id',
            '{{%shop}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-option-shop', '{{%option}}');
        $this->dropColumn('{{%option}}', 'shop_id');
    }

}
