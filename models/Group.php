<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $number
 * @property string $specialisation_id
 * @property string $start_date
 * @property int $faculty_id
 * @property Specialisation $specialisation
 * @property Faculty $faculty
 */
class Group extends ActiveRecord
{
    public static function tableName()
    {
        return 'group';
    }

    public function rules()
    {
        return [
            [['number', 'specialisation_id', 'start_date', 'faculty_id'], 'required'],
            [['specialisation_id', 'faculty_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['start_date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер группы',
            'specialisation' => 'Направление',
            'start_date' => 'Год поступления',
            'faculty_id' => 'Факультет',
        ];
    }
}