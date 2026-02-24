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
        $this->addForeignKey(
            'fk_group_specialisation',
            'group',
            'specialisation_id',
            'specialisation',
            'id'
        );
        $this->addForeignKey(
            'fk_group_faculty',
            'group',
            'faculty_id',
            'faculty',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('group');
    }
}
