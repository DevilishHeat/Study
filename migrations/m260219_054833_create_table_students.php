<?php

use yii\db\Migration;

class m260219_054833_create_table_students extends Migration
{

    public function safeUp()
    {
        $this->createTable('student', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(),
            'phone' => $this->string(),
            'group_id' => $this->integer(),
            'payment_type_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_student_group', 'student', 'group_id', 'group', 'id');
    }


    public function safeDown()
    {
        $this->dropTable('student');
    }
}
