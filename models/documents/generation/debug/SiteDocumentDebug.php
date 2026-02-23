<?php

namespace proleads\documents\models\generation\debug;

use kartik\select2\Select2;
use proleads\documents\models\generation\model\SiteDocumentGenerator;
use proleads\documents\models\generation\root\DocumentGenerator;
use proleads\documents\models\records\Document;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

class SiteDocumentDebug extends BaseDebugDocumentModel
{
    public ?int $site_document_id = null;

    public function rules()
    {
        $rules = parent::rules();
        unset($rules['contentRequired']);
        unset($rules['variablesRequired']);

        $rules = array_merge($rules, [
            [['site_document_id'], 'required'],
            [['site_document_id'], 'exist', 'targetClass' => Document::class, 'targetAttribute' => 'id'],
        ]);

        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function generateFormFields(ActiveForm $form){

        $documents = Document::find()->with('site')->all();
        echo $form->field($this, 'site_document_id')
            ->widget(Select2::class, [
                'data' => ArrayHelper::map($documents, 'id', function (Document $document) {
                    return "$document->title_ru ({$document->site->title})";
                }),
                'options' => [
                    'placeholder' => 'Id документа'
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getGenerator(): DocumentGenerator
    {
        $generator = new SiteDocumentGenerator([
            'document' => Document::findOne($this->site_document_id)
        ]);

        $generator->fileConfig = null;

        return $generator->generator;
    }
}