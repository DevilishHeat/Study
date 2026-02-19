<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $number
 * @property string $specialisation_id
 * @property string $start_date
 *
 * @property Specialisation $specialisation
 */
class Group extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер группы',
            'specialisation' => 'Специализация',
            'start_date' => 'Год поступления',
        ];
    }
}