<?php

namespace proleads\documents\models\generation\model;

use app\models\tags\TagCollection;
use proleads\documents\models\enums\ResultTypeEnum;
use proleads\documents\models\generation\model\configs\FileConfig;
use proleads\documents\models\generation\root\DocumentGenerator;
use proleads\documents\models\generation\root\output\ResultObject;
use proleads\documents\models\generation\root\output\ResultPdfObject;
use Yii;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\helpers\FileHelper;

class BaseDocumentGenerator extends BaseObject
{
    public string $resultType = ResultTypeEnum::FILE;

    public ?FileConfig $fileConfig = null;

    public string $content = '';
    public ?TagCollection $tagCollection = null;

    public ?DocumentGenerator $generator = null;

    protected ?ResultObject $_result = null;

    public function init()
    {
        parent::init();

        $this->generator = new DocumentGenerator([
            'contentObject' => $this->content,
            'tagCollection' => $this->tagCollection,
        ]);
    }

    public function getResult(): ?ResultObject
    {
        if ($this->_result !== NULL) {
            return $this->_result;
        }

        try {
            return $this->_result = match ($this->resultType) {
                ResultTypeEnum::HTML => $this->generator->getHtml(),
                ResultTypeEnum::BROWSER => $this->generator->getPdf(),
                ResultTypeEnum::FILE => $this->generator->getString(),
            };
        } catch (\Exception $exception) {
            Yii::$app->errorHandler->logException($exception);
            $this->_result = match ($this->resultType) {
                ResultTypeEnum::HTML => new ResultObject(),
                ResultTypeEnum::BROWSER => new ResultPdfObject(),
                ResultTypeEnum::FILE => throw $exception,
            };
            return $this->_result;
        }
    }

    public function generate(): ?ResultObject
    {

        $result = $this->getResult();

        if (
            $this->resultType == ResultTypeEnum::FILE &&
            $this->fileConfig
        ) {
            $this->saveFile();
        }

        return $result;
    }

    public function saveFile()
    {
        if (!$this->fileConfig?->getFileDir() || !$this->fileConfig?->fileName) {
            throw new Exception('Не задан путь для сохранения документа');
        }

        $fileDir = $this->fileConfig->getFileDir();
        if (!FileHelper::createDirectory($fileDir)) {
            throw new Exception('Не создана директория ' . $fileDir);
        }


        $filePath = "$fileDir/{$this->fileConfig->fileName}";

        if (file_exists($filePath)) {
            FileHelper::unlink($filePath);
        }

        if (!file_put_contents($filePath, $this->_result->getResult())) {
            throw new Exception('Не записан файл ' . $filePath);
        }
    }
}