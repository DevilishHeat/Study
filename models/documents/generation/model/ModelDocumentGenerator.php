<?php

namespace proleads\documents\models\generation\model;

use Mpdf\MpdfException;
use proleads\documents\models\enums\ResultTypeEnum;
use proleads\documents\models\generation\model\configs\FileConfig;
use proleads\documents\models\generation\model\configs\ResultConfig;
use proleads\documents\models\generation\root\DocumentGenerator;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\root\input\VariablesObject;
use proleads\documents\models\generation\root\output\ResultObject;
use proleads\documents\models\generation\root\output\ResultPdfObject;
use proleads\documents\traits\DocumentsModuleTrait;
use proleads\documents\traits\ModelDocumentGeneratorTrait;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\base\InvalidConfigException;

abstract class ModelDocumentGenerator extends BaseObject
{
    const DYNAMIC_VARIABLE = 'dynamic';

    use DocumentsModuleTrait;
    use ModelDocumentGeneratorTrait;

    /**
     * Отметка о том что нужно не смотря на условия перегенерировать документы
     * @var bool
     */
    public $forceRegenerate = false;

    /**
     * Конфиг результата - в каком виде нужно сгенерировать документ
     * @var ResultConfig|null|array $config
     */
    public ResultConfig|array|null $config = null;

    /**
     * Настройки пути файла
     * @var FileConfig|null $fileConfig
     */
    public ?FileConfig $fileConfig = null;

    /**
     * Модель, генерирующая документ в заданном ResultConfig'ом виде
     * @var DocumentGenerator|null $generator
     */
    public ?DocumentGenerator $generator = null;

    protected ?ResultObject $_result = null;

    /**
     * Инициализация генератора
     * @return void
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (is_array($this->config)) {
            $this->config['class'] = ($this->config['class'] ?? null) ?: ResultConfig::class;
            $this->config = Yii::createObject($this->config);
        }

        $this->generator = new DocumentGenerator([
            'contentObject' => $this->getContent(),
            'variablesObject' => $this->getVariables(),
        ]);
    }

    /**
     * Получение шаблона документа
     * @return ContentObject
     */
    public abstract function getContent(): ContentObject;

    /**
     * Получение значений для подстановки в шаблон
     * @return VariablesObject
     */
    public abstract function getVariables(): VariablesObject;

    /**
     * @throws CrossReferenceException
     * @throws MpdfException
     * @throws InvalidConfigException
     * @throws PdfParserException
     * @throws PdfTypeException
     */
    public function getResult(): ?ResultObject
    {
        if ($this->_result !== NULL) {
            return $this->_result;
        }

        try {

            return $this->_result = match ($this->config->type) {
                ResultTypeEnum::HTML => $this->generator->getHtml(),
                ResultTypeEnum::BROWSER => $this->generator->getPdf(),
                ResultTypeEnum::FILE => $this->generator->getString(),
            };

        } catch (\Exception $exception) {
            Yii::$app->errorHandler->logException($exception);

            $this->_result = match ($this->config->type) {
                ResultTypeEnum::HTML =>  new ResultObject(),
                ResultTypeEnum::BROWSER => new ResultPdfObject(),
                ResultTypeEnum::FILE => throw $exception,
            };

            return $this->_result;
        }
    }

    /**
     * @throws InvalidConfigException
     * @throws PdfTypeException
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws PdfParserException
     * @throws Exception
     */
    public function generate(): ?ResultObject
    {

        $result = $this->getResult();

        if (
            $this->config->type == ResultTypeEnum::FILE &&
            $this->fileConfig
        ) {
            $this->saveFile();
        }

        return $result;
    }


}