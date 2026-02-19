<?php

use yii\db\Migration;

class m260219_061056_create_table_specialisation extends Migration
{

    public function safeUp()
    {
        $this->createTable('specialisation', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('specialisation');
    }
}
