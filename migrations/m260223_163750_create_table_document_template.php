<?php

use yii\db\Migration;

class m260223_163750_create_table_document_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('document_template', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'template' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('document_template');
    }
}
