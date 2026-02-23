<?php

namespace proleads\documents\models\generation\root;

use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\root\input\ContentTypeEnum;
use proleads\documents\models\generation\root\output\ResultHtmlObject;
use proleads\documents\models\generation\root\output\ResultObject;
use proleads\documents\models\generation\root\output\ResultPdfObject;
use proleads\documents\models\generation\root\input\VariablesObject;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use function preg_replace;

class DocumentGenerator extends BaseObject
{

    /**
     * Если true включен режим дебага
     * во включенном режиме не найденные значения замены не исчезают, а остаются в тексте
     * @var bool
     */
    public $isDebug = false;

    /**
     * Класс возвращаемого генератором объекта
     * @var string
     */
    public string $resultObjectClass = ResultObject::class;

    /**
     * Первоначальное содержимое с тегами для замены
     * @var ContentObject|null $contentObject
     */
    public ?ContentObject $contentObject = null;

    /**
     * Массив значений для подстановки
     * @var VariablesObject|null $variablesObject
     */
    public ?VariablesObject $variablesObject = null;

    /**
     * Окончательный html текст документа
     * @var string $result
     */
    private ?string $result = null;

    public function init()
    {
        parent::init();

        ini_set('pcre.backtrack_limit', '5000000');
    }

    /**
     * Подстановка замен
     * @return void
     */
    public function getResult()
    {
        if($this->result !== NULL){
            return $this->result;
        }

        $this->result = $this->contentObject->getContent();
        $this->replaceTypeBlocks();
        $variables = $this->replaceVariablesRecursive($this->variablesObject->getVariables());
        foreach ($variables as $variable => $value) {
            $this->result = str_replace("{{$variable}}", $value, $this->result);
        }

        if(!$this->isDebug) {
            $this->result = preg_replace("/{([^}]+)}/u", "", $this->result);
        }

        return $this->result;
    }

    /**
     * Получение документа в HTML
     * @return ResultHtmlObject
     */
    public function getHtml(): ResultHtmlObject
    {
        return new ResultHtmlObject([
            'result' => $this->getResult()
        ]);
    }

    /**
     * Вывод PDF документа в браузере
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function getString(): ResultObject
    {
        return new $this->resultObjectClass([
            'result' => (new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_STRING,
                'content' => $this->getResult(),
            ]))->render(),
        ]);
    }

    /**
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function getPdf(): ResultObject
    {
        $this->resultObjectClass = ResultPdfObject::class;
        return $this->getString();
    }

    /**
     * @param array $variables
     * @return array
     */
    private function replaceVariablesRecursive(array $variables): array
    {
        for ($a = 0; $a <= 10; $a++) {

            $count = 0;

            foreach ($variables as &$value) {
                if (!preg_match_all("/\{[\w.]+?\}/", $value, $matches)) {
                    continue;
                }

                $count++;

                $value = str_replace(
                    $matches[0],
                    array_map(
                        function ($m) use ($variables) {
                            $m = trim($m, "{");
                            $m = trim($m, "}");

                            if (!array_key_exists($m, $variables)) {
                                Yii::error("Значения при генерации документа не нашлось $m");
                            }

                            return $variables[$m] ?? null;
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

        return $variables;
    }

    private function replaceTypeBlocks(): void
    {
        $types = implode('|', array_keys(ContentTypeEnum::getAllTitles()));
        $result = [];
        $matchCount = preg_match_all("/($types)=\[(\X+?)]/", $this->result, $matches);
        if (!$matchCount) {
            return;
        }

        for ($matchCount; $matchCount > 0; $matchCount--) {
            $result[] = ArrayHelper::getColumn($matches, $matchCount - 1);
        }
        foreach ($result as $item) {
            if ($item[1] == $this->contentObject->type) {
                $this->result = str_replace($item[0], $item[2], $this->result);
            } else {
                $this->result = str_replace($item[0], '', $this->result);
            }
        }
    }
}