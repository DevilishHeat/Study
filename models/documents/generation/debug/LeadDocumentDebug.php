<?php

namespace proleads\documents\models\generation\debug;

use common\models\LoanRequest;
use proleads\documents\models\generation\model\LeadDocumentGenerator;
use proleads\documents\models\generation\root\DocumentGenerator;
use proleads\documents\models\records\LeadDocumentType;
use proleads\documents\traits\DocumentsModuleTrait;
use proleads\helps\common\models\Bh;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use function array_merge;

class LeadDocumentDebug extends BaseDebugDocumentModel{

    use DocumentsModuleTrait;

    public $loan_request_id;

    public $lead_document_type_id;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        $rules = parent::rules();
        unset($rules['contentRequired']);
        unset($rules['variablesRequired']);

        $rules = array_merge($rules, [
            [['loan_request_id'], 'required'],
            [['loan_request_id'], 'exist', 'targetClass'=>$this->module->getModel('LoanRequest'), 'targetAttribute'=>'id'],

            [['lead_document_type_id'], 'required'],
            [['lead_document_type_id'], 'exist', 'targetClass'=>LeadDocumentType::class, 'targetAttribute'=>'id']
        ]);

        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function generateFormFields(ActiveForm $form){

        echo $form->field($this, 'loan_request_id')
            ->textInput()
            ->hint("Id заявки");

        $leadDocumentTypes = LeadDocumentType::find()
            ->innerJoinWith('documentTemplate')
            ->all();

        $leadDocumentTypes = ArrayHelper::map($leadDocumentTypes, 'id', function($m){
            return $m->getBackendTitle()." ".$m->id;
        });

        echo $form->field($this, 'lead_document_type_id')
            ->dropdownList($leadDocumentTypes)
            ->hint("Id из модели LeadDocumentType");
    }

    /**
     * @inheritDoc
     */
    public function getGenerator(): DocumentGenerator
    {
        $class = $this->getModule()->getModel('LeadDocumentGenerator');
        $generator = new $class([
            'documentType'=>LeadDocumentType::strictFindOne($this->lead_document_type_id),
            'loanRequest'=>$this->module->getModel('LoanRequest')::strictFindOne($this->loan_request_id)
        ]);

        $generator->fileConfig = null;

        return $generator->generator;
    }

}