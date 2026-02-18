<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property int $group_id
 * @property int $payment_type_id
 *
 * @property Group $group
 */
class Student extends ActiveRecord
{
    public function rules()
    {
        return [
            [['fio', 'phone', 'group_id', 'payment_type_id'], 'required'],
            [['group_id', 'payment_type_id'], 'integer'],
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
            'group_id' => 'Группа',
            'payment_type_id' => 'Форма обучения',
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}