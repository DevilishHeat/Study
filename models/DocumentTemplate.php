<?php

namespace app\models;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property string $template
 */
class DocumentTemplate extends ActiveRecord
{
    public static function tableName()
    {
        return 'document_template';
    }

    public function rules()
    {
        return [
            [['title', 'template'], 'required'],
            [['template', 'title'], 'string'],
            [['created_at', 'updated_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'template' => 'Шаблон',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
