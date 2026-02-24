<?php

namespace app\models\tags\fields;

use Closure;
use app\models\tags\groups\BaseGroup;
use Yii;
use yii\base\BaseObject;
use function call_user_func_array;


class BaseField extends BaseObject
{

    public ?string $description = null;

    public string $alias;

    public ?string $value = null;

    public ?Closure $valueClosure = null;

    private ?BaseGroup $group = null;

    public function setGroup(BaseGroup $group): object
    {
        $this->group = $group;
        return $this;
    }

    public function getGroup(): ?object
    {
        return $this->group;
    }

    public function initValue(): object
    {
        if ($this->value !== NULL) {
            return $this;
        }

        if ($this->valueClosure instanceof Closure) {
            try {
                $this->value = call_user_func_array($this->valueClosure, [$this]);
            } catch (\Exception $exception) {
                Yii::$app->errorHandler->logException($exception);
                $this->value = null;
            }

            return $this;
        }

        return $this;
    }
}
