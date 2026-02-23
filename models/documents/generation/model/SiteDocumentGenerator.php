<?php

namespace proleads\documents\models\generation\model;

use proleads\documents\models\generation\debug\SiteDocumentDebug;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\model\configs\FileConfig;
use proleads\documents\models\generation\root\input\ContentTypeEnum;
use proleads\documents\models\generation\root\input\VariablesObject;
use proleads\documents\models\records\Document;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;

class SiteDocumentGenerator extends ModelDocumentGenerator
{
    const DEBUG = SiteDocumentDebug::class;

    public ?Document $document = null;

    /**
     * Задание пути для сохранения файла
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->fileConfig = Yii::createObject([
            'class' => FileConfig::class,
            'rootDir' => $this->getModule()->rootDir,
            'webDir' => $this->getModule()->siteDocumentsWebDir,
            'fileName' => "{$this->document->id}.pdf"
        ]);
    }

    /**
     * Задание шаблона
     * @return ContentObject
     */
    public function getContent(): ContentObject
    {
        return new ContentObject([
            'content' => $this->document->template->template,
            'type' => ContentTypeEnum::SITE,
        ]);
    }

    /**
     * Получение значений тегов
     * @throws InvalidConfigException
     */
    public function getVariables(): VariablesObject
    {
        $lang = $this->document->template->language->alias ?? 'ru';
        return new VariablesObject([
            'variables' => $this->getModule()->getModel('SiteKit')::getTagsCollection($lang, $this->document->site)->getTagValues(),
        ]);
    }

    /**
     * Сохранение файла и его пути в модели документа
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function saveFile(): bool
    {
        parent::saveFile();

        $this->document->generate_pdf = "{$this->fileConfig->webDir}/{$this->fileConfig->fileName}";
        $this->document->strictSave();

        return true;
    }
}