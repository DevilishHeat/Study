<?php

use yii\db\Migration;

class m260219_061107_create_table_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'position_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
        ]);
        $this->addForeignKey(
            'fk_employee_position',
            'employee',
            'position_id',
            'position',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employee');
    }
}
