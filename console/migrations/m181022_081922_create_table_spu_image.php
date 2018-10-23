<?php

use yii\db\Query;

/**
 * Class m181022_081922_create_table_spu_image
 */
class m181022_081922_create_table_spu_image extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%spu_image}}', [
            'spu_id' => $this->bigInteger()->notNull(),
            'attachment_id' => $this->bigInteger()->notNull(),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-spu-image', '{{%spu_image}}', ['spu_id', 'attachment_id']);
        $this->addForeignKey(
            'fk-spu_image-spu',
            '{{%spu_image}}', 'spu_id',
            '{{%spu}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-spu_image-image',
            '{{%spu_image}}', 'attachment_id',
            '{{%attachment}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-spu_image-spu', '{{%spu_image}}');
        $this->dropForeignKey('fk-spu_image-image', '{{%spu_image}}');
        $this->dropTable('{{%spu_image}}');
    }

}
