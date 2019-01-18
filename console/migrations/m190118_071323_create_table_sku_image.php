<?php

use yii\db\Query;

/**
 * Class m190118_071323_create_table_sku_image
 */
class m190118_071323_create_table_sku_image extends yii\db\Migration
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
        $this->createTable('{{%sku_image}}', [
            'sku_id' => $this->bigInteger()->notNull(),
            'attachment_id' => $this->bigInteger()->notNull(),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-sku-image', '{{%sku_image}}', ['sku_id', 'attachment_id']);
        $this->addForeignKey(
            'fk-sku_image-sku',
            '{{%sku_image}}', 'sku_id',
            '{{%sku}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-sku_image-image',
            '{{%sku_image}}', 'attachment_id',
            '{{%attachment}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sku_image-spu', '{{%sku_image}}');
        $this->dropForeignKey('fk-sku_image-image', '{{%sku_image}}');
        $this->dropTable('{{%sku_image}}');
    }

}
