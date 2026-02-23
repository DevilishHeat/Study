<?php

namespace proleads\documents\models\generation\model;

use proleads\documents\models\generation\debug\VersionLeadDocumentDebug;
use proleads\documents\models\generation\root\input\ContentObject;
use proleads\documents\models\generation\root\input\ContentTypeEnum;
use proleads\documents\models\generation\root\input\VariablesObject;
use proleads\documents\models\records\LeadDocument;
use proleads\helps\common\models\Bh;
use Throwable;
use Yii;
use yii\helpers\Json;

class VersionLeadDocumentGenerator extends ModelDocumentGenerator
{
    const DEBUG = VersionLeadDocumentDebug::class;

    public ?LeadDocument $leadDocument = null;

    /**
     * @inheritDoc
     * @return ContentObject
     */
    public function getContent(): ContentObject
    {
        return new ContentObject([
            'content' => $this->leadDocument->documentTemplateVersion->template,
            'type' => ContentTypeEnum::LOAN_REQUEST,
        ]);
    }

    /**
     * @inheritDoc
     * @return VariablesObject
     */
    public function getVariables(): VariablesObject
    {
        $dynamicVariablesClosures = $this->getDynamicVariableValues();
        $variables = Json::decode($this->leadDocument->variables_compressed);
        array_walk($variables, function (&$value, $variable) use ($dynamicVariablesClosures) {
            if ($value != self::DYNAMIC_VARIABLE) {
                return;
            }

            try {
                $value = $dynamicVariablesClosures[$variable]();
            } catch (Throwable $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::error("Ошибка при замене переменной $variable в LeadDocument {$this->leadDocument->id}");
                $value = null;
            }
        });

        return new VariablesObject([
            'variables' => $variables,
        ]);
    }

    /**
     * Функции для вычисления динамических тегов
     * @return Closure[]
     */
    public function getDynamicVariableValues(): array
    {
        return [
            'legal_person.ur_stamp' => function () {
                $ur_stamp = null;
                if (
                    ($stampPath = Yii::getAlias("@backend{$this->leadDocument->loanRequest->site->legalPerson->ur_stamp}")) &&
                    is_file($stampPath)
                ) {
                    $ur_stamp = Bh::formImgTag($stampPath, 170, 177);
                }
                return $ur_stamp;
            },
            'ur_stamp' => function () {
                $ur_stamp = null;
                if (
                    ($stampPath = Yii::getAlias("@backend{$this->leadDocument->loanRequest->site->legalPerson->ur_stamp}")) &&
                    is_file($stampPath)
                ) {
                    $ur_stamp = Bh::formImgTag($stampPath, 170, 177);
                }
                return $ur_stamp;
            },
            'legal_person.ur_signature' => function () {
                $ur_signature = null;
                if (
                    ($signaturePath = Yii::getAlias("@backend{$this->leadDocument->loanRequest->site->legalPerson->ur_signature}")) &&
                    is_file($signaturePath)
                ) {
                    $imgStyle = 'margin-bottom:3px;padding-left:30px;padding-right:10px;';
                    $ur_signature = Bh::formImgTag($signaturePath, 82, 76, $imgStyle);
                }
                return $ur_signature;
            },
            'ur_signature' => function () {
                $ur_signature = null;
                if (
                    ($signaturePath = Yii::getAlias("@backend{$this->leadDocument->loanRequest->site->legalPerson->ur_signature}")) &&
                    is_file($signaturePath)
                ) {
                    $imgStyle = 'margin-bottom:3px;padding-left:30px;padding-right:10px;';
                    $ur_signature = Bh::formImgTag($signaturePath, 82, 76, $imgStyle);
                }
                return $ur_signature;
            },
        ];
    }
}