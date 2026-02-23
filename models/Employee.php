<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property string $position
 * @property int $faculty_id
 *
 * @property Faculty $faculty
 */
class Employee extends ActiveRecord
{
    public static function tableName()
    {
        return 'employee';
    }


    public function rules()
    {
        return [
            [['fio', 'phone', 'position', 'faculty_id'], 'required'],
            [['faculty_id'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'position' => 'Должность',
            'faculty_id' => 'Факультет',
        ];
    }
    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

}