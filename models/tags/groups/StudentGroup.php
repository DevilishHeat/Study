<?php

namespace app\models\tags\groups;

use app\models\enums\PaymentTypeEnum;
use app\models\Student;
use app\models\tags\fields\BaseField;
use app\models\tags\params\StudentParam;
use Exception;

class StudentGroup extends BaseGroup
{
    public string $alias = 'student';
    public string|null $description = 'Студент';

    private Student|null $student = null;

    public function initGroup()
    {
        if (!$param = $this->collection->getParam(StudentParam::class)) {
            throw new Exception("Collection must have StudentParam");
        }

        $this->student = $param->student;
    }

    public function getFieldsConfig(): array
    {
        if (!$this->student) {
            return [];
        }

        return [
            'fio' => [
                'value' => $this->student->fio,
                'description' => 'ФИО',
            ],
            'telephone' => [
                'value' => $this->student->phone,
                'description' => 'Телефон',
            ],
            'group' => [
                'value' => $this->student->group->number ?? '',
                'description' => 'Группа',
            ],
            'payment_type' => [
                'value' => PaymentTypeEnum::getList()[$this->student->payment_type_id] ?? '',
                'description' => 'Форма обучения',
            ],
            'faculty' => [
                'value' => $this->student->group->faculty->name ?? '',
                'description' => 'Факультет',
            ],
        ];
    }
}