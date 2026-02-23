<?php

namespace proleads\documents\models\generation\debug;

use dosamigos\tinymce\TinyMce;
use Mpdf\MpdfException;
use proleads\documents\DocumentsModule;
use proleads\documents\models\enums\ResultTypeEnum;
use proleads\documents\models\generation\root\DocumentGenerator;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\root\input\VariablesObject;
use proleads\documents\traits\DocumentsModuleTrait;
use proleads\helps\common\models\CommonModel;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Yii;
use yii\base\Exception;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use function array_map;
use function explode;
use function get_class;
use function ob_get_clean;
use function ob_start;

class BaseDebugDocumentModel extends CommonModel{

    use DocumentsModuleTrait;

    public $content = null;

    public $variables = null;

    public $resultType = ResultTypeEnum::BROWSER;

    public function rules(){

        return [
            'contentRequired'=>[['content'], 'required'],
            'variablesRequired'=>[['variables'], 'safe'],

            [['resultType'], 'required'],
            [['resultType'], 'default', 'value'=>ResultTypeEnum::BROWSER]
        ];
    }

    public function generateFormFields(ActiveForm $form){

        echo $form->field($this, 'content')
            ->widget(TinyMce::class, [])
            ->hint("test pdf {test} {test2}");

        echo $form->field($this, 'variables')
            ->textInput()
            ->hint('test="var from variables", test2="var from variables 2"');

    }

    /**
     * Формирует форму для дебагера
     * @return false|string
     */
    public function generateForm(){

        ob_start();

        $form = ActiveForm::begin();

        echo Html::tag('h4', StringHelper::basename(get_class($this)));

        $this->generateFormFields($form);

        echo $form->field($this, 'resultType')->dropdownList([
            ResultTypeEnum::HTML=>ResultTypeEnum::getAllTitles()[ResultTypeEnum::HTML],
            ResultTypeEnum::BROWSER=>ResultTypeEnum::getAllTitles()[ResultTypeEnum::BROWSER],
        ]);

        echo Html::submitButton(DocumentsModule::t('app', 'to_form'), ['class'=>'btn btn-success']);

        ActiveForm::end();

        $content = ob_get_clean();

        return $content;
    }

    /**
     * Возвращает массив переменных для замены в документе
     * @return array
     */
    public function getVariables():array{
        if (!$this->variables) {
            return [];
        }

        $variables = explode(",", $this->variables);
        $variables = array_map('trim', $variables);

        $variables = array_map(function($m){
            $t = array_map(function($mm){
                return trim(trim($mm, "\""), "'");
            },explode("=", $m));

            return $t;
        }, $variables);

        $variables = ArrayHelper::map(
            $variables,
            function($v){
                return $v[0];
            },
            function($v){
                return $v[1];
            }
        );

        return $variables;
    }

    /**
     * Возвращает шаблон документа
     * @return string
     */
    public function getContent():?string{
        return $this->content;
    }

    /**
     * Возвращает модель генератора документа
     * @return DocumentGenerator
     */
    public function getGenerator():DocumentGenerator{

        return new DocumentGenerator([
            'contentObject'=>new ContentObject([
                'content'=>$this->getContent()
            ]),
            'variablesObject'=>new VariablesObject([
                'variables'=>$this->getVariables()
            ])
        ]);

    }

    /**
     * Метод вызывается до {@see BaseDebugDocumentModel::createPdf()} для инициализации чего либо
     * @return void
     */
    public function beforeCreatePdf(){

    }

    /**
     * В зависимости от переданного {@see BaseDebugDocumentModel::$resultType} формирует клиенту пдф
     * @return void
     * @throws Exception
     * @throws MpdfException
     * @throws CrossReferenceException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws InvalidConfigException|ExitException
     */
    public function createPdf(){
        $this->beforeCreatePdf();

        $generator = $this->getGenerator();

        $generator->isDebug = true;

        match ($this->resultType) {
            ResultTypeEnum::BROWSER => $generator->getPdf()->sendToBrowser(),
            ResultTypeEnum::FILE => throw new Exception("Result type to file not work"),
            ResultTypeEnum::HTML => $generator->getHtml()->sendToBrowser(),
        };

        Yii::$app->end();
    }

}