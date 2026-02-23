<?php

namespace proleads\documents\models\generation\model;

use common\models\LoanRequest;
use proleads\documents\models\enums\LeadDocumentStatus;
use proleads\documents\models\generation\debug\LeadDocumentDebug;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\model\configs\FileConfig;
use proleads\documents\models\generation\root\input\ContentTypeEnum;
use proleads\documents\models\generation\root\input\VariablesObject;
use proleads\documents\models\records\DocumentTemplateVersion;
use proleads\documents\models\records\LeadDocument;
use proleads\documents\models\records\LeadDocumentType;
use proleads\documents\traits\DocumentsModuleTrait;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * Клас генерации документов для заявки
 *
 * @property LeadDocumentType $documentType
 * @property LoanRequest $loanRequest
 *
 */
class LeadDocumentGenerator extends ModelDocumentGenerator
{
    use DocumentsModuleTrait;

    const DEBUG = LeadDocumentDebug::class;

    public LeadDocumentType $documentType;

    public LoanRequest $loanRequest;

    /**
     * Задание пути для сохранения файла
     * @return void
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->initFileConfig();
    }

    private function initFileConfig(){
        $this->fileConfig = Yii::createObject([
            'class' => FileConfig::class,
            'rootDir' => $this->getModule()->rootDir,
            'webDir' => $this->getWebDir($this->loanRequest->id, $this->getModule()->leadDocumentsWebDir),
            'fileName' => "{$this->documentType->id}-{$this->loanRequest->id}.pdf",
        ]);
    }

    /**
     * Задание шаблона
     * @return ContentObject
     */
    public function getContent(): ContentObject
    {
        return new ContentObject([
            'content' => $this->documentType->documentTemplate->template,
            'type' => ContentTypeEnum::LOAN_REQUEST,
        ]);
    }

    /**
     * Получение значений тегов
     * @throws InvalidConfigException
     */
    public function getVariables(): VariablesObject
    {
        $lang = $this->documentType->documentTemplate->language->alias ?? 'ru';
        return new VariablesObject([
            'variables' => $this->getModule()->getModel('LoanRequestKit')::getTagsCollection($lang, $this->loanRequest)->getTagValues()
        ]);
    }

    /**
     * Сохранение файла и его пути в модели документа
     * @throws Throwable
     */
    public function saveFile(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            if($this->forceRegenerate) {
                $oldModel = $this->getModule()->getModel('LeadDocument')::findOne([
                    'lead_document_type_id' => $this->documentType->id,
                    'loan_request_id' => $this->loanRequest->id
                ]);
            }


            /* @var LeadDocument $leadDocument */
            $leadDocument = new ($this->getModule()->getModel('LeadDocument'));
            $leadDocument->lead_document_type_id = $this->documentType->id;
            $leadDocument->loan_request_id = $this->loanRequest->id;

            $tags = $this->getVariables()->getVariables();

            foreach ($this->getDynamicVariables() as $dynamicVariable) {
                $tags[$dynamicVariable] = self::DYNAMIC_VARIABLE;
            }

            $templateVersion = DocumentTemplateVersion::findOne([
                'version' => $this->documentType->documentTemplate->version,
                'template_id' => $this->documentType->document_template_id,
            ]);
            $usedTags = [];
            preg_match_all('/{([^}]+)}/u', $templateVersion->template, $usedTags);
            $usedTags = $usedTags[1] ?? [];
            $usedTags = array_filter($tags, function ($key) use ($usedTags) {
                return in_array($key, $usedTags);
            }, ARRAY_FILTER_USE_KEY);

            $leadDocument->variables_compressed = Json::encode($usedTags);
            $leadDocument->template_version_id = $templateVersion->id;
            $leadDocument->strictSave();

            parent::saveFile();

            $leadDocument->document_path = $this->fileConfig->getFilePath(true);
            $leadDocument->status = $this->getDocumentStatus();
            $leadDocument->strictSave();

            if(($oldModel??null) && $this->forceRegenerate){
                $oldModel->delete();
            }

            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::error([
                'loan_request_id' => $this->loanRequest->id,
                'doc_type_id' => $this->documentType->id,
                'message' => $exception->getMessage(),
            ], __METHOD__);
            $transaction->rollBack();
            throw $exception;
        }

        return true;
    }

    /**
     * Перечень тегов, значение которых не должно сохраняться в базу
     * @return string[]
     */
    public function getDynamicVariables(): array
    {
        return [
            'legal_person.ur_stamp',
            'ur_stamp',
            'legal_person.ur_signature',
            'ur_signature',
        ];
    }

    /**
     * Возвращает статус документа
     * @return int
     */
    protected function getDocumentStatus(): int
    {
        return LeadDocumentStatus::STATUS_READY;
    }
}