<?php

use yii\db\Migration;

class m260219_060526_create_table_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('group', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notNull(),
            'specialisation_id' => $this->integer()->notNull(),
            'start_date' => $this->string()->notNull(),
            'faculty_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('group');
    }
}
