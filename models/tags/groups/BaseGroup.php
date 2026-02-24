<?php

namespace app\models\tags\groups;

use app\models\tags\fields\BaseField;
use app\models\tags\TagCollection;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use function array_map;

abstract class BaseGroup extends BaseObject
{

    public string $alias;

    private array $fields = [];

    private ?TagCollection $collection = null;

    public string|null $description = null;

    public function init()
    {
        parent::init();

        if (!$this->alias) {
            throw new Exception("Group alias not set");
        }
    }

    abstract public function initGroup();

    abstract public function getFieldsConfig(): array;

    public function initFields()
    {
        $fieldsConfig = $this->getFieldsConfig();

        foreach ($fieldsConfig as $fieldAlias => $fieldConfig) {
            $fieldConfig['class'] = $fieldConfig['class'] ?? BaseField::class;
            $fieldConfig['alias'] = $fieldAlias;

            $this->addField($fieldConfig);
        }
    }

    public function setCollection(TagCollection $collection): object
    {
        $this->collection = $collection;
        return $this;
    }

    public function getCollection(): ?object
    {
        return $this->collection;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields($fields): object
    {
        $fields = array_map(function ($f) {
            $f->setGroup($this);
            return $f;
        }, $fields);

        $this->fields = $fields;
        return $this;
    }

    public function addField($fieldConfig): object
    {

        $field = Yii::createObject($fieldConfig);

        $field->setGroup($this);

        $this->fields[$field->alias] = $field;
        return $this;
    }

    public function getField(string $alias): ?object
    {
        return $this->fields[$alias] ?? null;
    }

    public function getFieldAlias(BaseField $field): ?string
    {
        if (!($this->fields[$field->alias] ?? null)) {
            return null;
        }

        return $this->alias . "." . $field->alias;
    }
}