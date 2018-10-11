<?php

use yii\db\Migration;

/**
 * Class m171114_060936_create_table_map
 */
class m171114_060936_create_table_map extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('map', [
			'id' => $this->bigPrimaryKey(),
            'type' => $this->string(100)->notNull(),
            'from_id' => $this->bigInteger()->notNull(),
            'to_id' => $this->bigInteger()->notNull(),
        ], $tableOptions);
        /*
        $this->addForeignKey(
            'fk-visit-interaction',
            '{{%visit}}', 'id',
            '{{%interaction}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        */

    }

    public function safeDown()
    {
		//$this->dropForeignKey('fk-visit-interaction', '{{%visit}}');
		$this->dropTable('map');
    }
}
