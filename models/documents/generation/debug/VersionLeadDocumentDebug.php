<?php

namespace proleads\documents\models\generation\debug;

use proleads\documents\models\records\LeadDocument;
use Yii;
use yii\widgets\ActiveForm;
use proleads\documents\models\generation\root\DocumentGenerator;

class VersionLeadDocumentDebug extends BaseDebugDocumentModel
{

    public $lead_document_id;

    public function rules()
    {
        $rules = parent::rules();
        unset($rules['contentRequired']);
        unset($rules['variablesRequired']);

        $rules = array_merge($rules, [
            [['lead_document_id'], 'required'],
            [['lead_document_id'], 'exist', 'targetClass' => LeadDocument::class, 'targetAttribute' => 'id'],
        ]);

        return $rules;
    }

    public function generateFormFields(ActiveForm $form){

        echo $form->field($this, 'lead_document_id')
            ->textInput()
            ->hint("Id документа");
    }

    public function getGenerator(): DocumentGenerator
    {
        $generator = Yii::createObject([
            'class' => $this->getModule()->getModel('VersionLeadDocumentGenerator'),
            'leadDocument' => LeadDocument::findOne($this->lead_document_id)
        ]);

        $generator->fileConfig = null;

        return $generator->generator;
    }
}