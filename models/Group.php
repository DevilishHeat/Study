<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $number
 * @property string $specialisation
 *
 */
class Group extends ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер группы',
            'specialisation' => 'Специализация',
        ];
    }
}