<?php

namespace app\models\tags\groups;

use app\models\Employee;
use app\models\tags\params\EmployeeParam;
use Exception;

class EmployeeGroup extends BaseGroup
{
    public string $alias = 'employee';
    public string|null $description = 'Сотрудник';
    private Employee|null $employee = null;

    public function initGroup()
    {
        if (!$param = $this->collection->getParam(EmployeeParam::class)) {
            throw new Exception("Collection must have EmployeeParam");
        }

        $this->employee = $param->employee;
    }

    public function getFieldsConfig(): array
    {
        if (!$this->employee) {
            return [];
        }

        return [
            'fio' => [
                'value' => $this->employee->fio,
                'description' => 'ФИО',
            ],
            'position' => [
                'value' => $this->employee->position,
                'description' => 'Должность',
            ],
        ];
    }
}