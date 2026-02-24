<?php

namespace app\models\tags;

use app\models\tags\fields\BaseField;
use app\models\tags\groups\BaseGroup;
use app\models\tags\params\BaseParam;
use app\models\tags\params\ClearFromEOLParam;
use Exception;
use TagsDescriptionWidget;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use function array_keys;
use function array_map;
use function get_class;
use function preg_match_all;
use function str_replace;

class TagCollection extends BaseObject
{
    private array $groups = [];

    private array $tagValues = [];

    private array $params = [];

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam($paramsClass): ?BaseParam
    {
        return $this->params[$paramsClass] ?? null;
    }

    public function setParams(array $params): object
    {
        $this->params = array_map(function ($p) {
            return Yii::createObject($p);
        }, $params);

        $this->params = ArrayHelper::index($this->params, function ($p) {
            return get_class($p);
        });

        return $this;
    }

    public function addParam(array $paramConfig): object
    {
        $paramObject = Yii::createObject($paramConfig);
        $this->params[get_class($paramObject)] = $paramObject;
        return $this;
    }

    public function getTagValues(): array
    {
        return $this->tagValues;
    }

    public function addGroup(array $groupConfig): object
    {
        /** @var BaseGroup $group */
        $group = Yii::createObject($groupConfig);

        $group->setCollection($this);
        $group->initGroup();
        $group->initFields();

        $this->groups[get_class($group)] = $group;
        return $this;
    }

    public function setGroups(array $groupsData = []): object
    {
        foreach ($groupsData as $groupsDatum) {
            $this->addGroup($groupsDatum);
        }
        return $this;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function initVariables()
    {
        foreach ($this->groups as $group) {

            foreach ($group->fields as $field) {

                if (!($alias = $group->getFieldAlias($field))) {
                    Yii::error("У поля тега не задан алиас");
                    continue;
                }

                $this->tagValues[$alias] = $field->value;
            }

        }

        $this->initRecursive();

        return $this;
    }

    private function initRecursive()
    {
        for ($a = 0; $a <= 10; $a++) {
            $count = 0;
            foreach ($this->tagValues as $fieldAlias => &$value) {
                if (!preg_match_all("/\{[\w.]+?\}/", $value, $matches)) {
                    continue;
                }
                $count++;
                $value = str_replace(
                    $matches[0],
                    array_map(
                        function ($m)use($fieldAlias){
                            $m = trim($m, "{");
                            $m = trim($m, "}");
                            Yii::error([
                                "message"=>"значения в рекурсии не нашлось $m",
                                "fieldAlias"=>$fieldAlias,
                                'tagValuesKeys'=>array_keys($this->tagValues)
                            ]);

                            return $this->tagValues[$m] ?? null;
                        },
                        $matches[0]
                    ),
                    $value
                );

            }
            if (!$count) {
                break;
            }
        }
        return $this;
    }

    public function replaceTags(string|null $text): string
    {
        if (!$text) {
            return '';
        }

        if($this->getParam(ClearFromEOLParam::class)){
            $text =  str_replace("\r\n", "", $text);
        }

        $tags = array_map(function ($alias) {
            return "{{$alias}}";
        }, array_keys($this->tagValues));
        $content = str_replace($tags, array_values($this->tagValues), $text);
        return preg_replace("/{([^}]+)}/u", "", $content);
    }

    public function getDescriptionWidget(): string
    {
        return TagsDescriptionWidget::widget(['tagCollection' => $this]);
    }

    public function getField(string $groupClass, string $fieldAlias): ?BaseField
    {
        return $this->groups[$groupClass]->fields[$fieldAlias] ?? null;
    }
}