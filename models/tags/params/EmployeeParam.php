<?php

namespace app\models\tags\params;

use app\models\Employee;

class EmployeeParam extends BaseParam
{
    public Employee|null $employee = null;
}