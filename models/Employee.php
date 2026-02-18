<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property string $position
 */
class Employee extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'position' => 'Должность',
        ];
    }
}