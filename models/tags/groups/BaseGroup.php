<?php

namespace app\models\tags\groups;

use app\models\tags\fields\BaseField;
use app\models\tags\TagCollection;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use function array_map;

/**
 * @property TagCollection|null $collection
 * @property string|null $language
 * @property BaseField[] $fields
 */
abstract class BaseGroup extends BaseObject
{

    /**
     * Алиас группы
     * @var string $alias
     */
    public string $alias;

    /**
     * @var BaseField[] $fields
     */
    private array $fields = [];

    /**
     * @var TagCollection|null $collection
     */
    private ?TagCollection $collection = null;


    /**
     * @var string|null $description
     */
    public string|null $description = null;

    public function init()
    {
        parent::init();

        if (!$this->alias) {
            throw new Exception("Group alias not set");
        }
    }

    abstract public function initGroup();

    /**
     * Описание конфига полей группы
     * @return array
     */
    abstract public function getFieldsConfig(): array;

    /**
     * @throws InvalidConfigException
     */
    public function initFields()
    {
        $fieldsConfig = $this->getFieldsConfig();

        foreach ($fieldsConfig as $fieldAlias => $fieldConfig) {
            $fieldConfig['class'] = $fieldConfig['class'] ?? BaseField::class;
            $fieldConfig['alias'] = $fieldAlias;

            $this->addField($fieldConfig);
        }
    }

    /**
     * @param TagCollection $collection
     * @return object
     */
    public function setCollection(TagCollection $collection): object
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * @return TagCollection|null
     */
    public function getCollection(): ?object
    {
        return $this->collection;
    }

    /**
     * @return BaseField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param $fields
     * @return $this
     */
    public function setFields($fields): object
    {
        $fields = array_map(function ($f) {
            $f->setGroup($this);
            return $f;
        }, $fields);

        $this->fields = $fields;
        return $this;
    }

    /**
     * @param BaseField $field
     * @return $this
     */
    public function addField($fieldConfig): object
    {

        $field = Yii::createObject($fieldConfig);

        $field->setGroup($this);

        $this->fields[$field->alias] = $field;
        return $this;
    }

    /**
     * @param string $alias
     * @return object|null
     */
    public function getField(string $alias): ?object
    {
        return $this->fields[$alias] ?? null;
    }

    /**
     * @param BaseField $field
     * @return string|null
     */
    public function getFieldAlias(BaseField $field): ?string
    {
        if (!($this->fields[$field->alias] ?? null)) {
            return null;
        }

        return $this->alias . "." . $field->alias;
    }
}