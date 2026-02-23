<?php

namespace app\models\tags\fields;

use Closure;
use app\models\tags\groups\BaseGroup;
use Yii;
use yii\base\BaseObject;
use function call_user_func_array;


/**
 * @property BaseGroup $group
 */
class BaseField extends BaseObject
{

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var string $alias
     */
    public string $alias;

    /**
     * @var null|string $value
     */
    public ?string $value = null;

    /**
     * @var null|Closure $valueClosure
     */
    public ?Closure $valueClosure = null;

    /**
     * @var BaseGroup|null $group
     */
    private ?BaseGroup $group = null;

    /**
     * @param BaseGroup $group
     * @return BaseField
     */
    public function setGroup(BaseGroup $group): object
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return BaseGroup|null
     */
    public function getGroup(): ?object
    {
        return $this->group;
    }

    /**
     * @return BaseField
     */
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
