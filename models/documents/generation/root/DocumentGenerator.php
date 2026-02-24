<?php

namespace proleads\documents\models\generation\root;

use app\models\tags\TagCollection;
use kartik\mpdf\Pdf;
use proleads\documents\models\generation\root\output\ResultHtmlObject;
use proleads\documents\models\generation\root\output\ResultObject;
use proleads\documents\models\generation\root\output\ResultPdfObject;
use yii\base\BaseObject;

class DocumentGenerator extends BaseObject
{
    public ?string $content = null;
    private ?string $result = null;
    public ?TagCollection $tagCollection = null;
    private string $resultObjectClass;

    public function getResult()
    {
        if ($this->result !== NULL) {
            return $this->result;
        }

        $this->result = $this->tagCollection->replaceTags($this->content);

        return $this->result;
    }

    public function getHtml(): ResultHtmlObject
    {
        return new ResultHtmlObject([
            'result' => $this->getResult()
        ]);
    }

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

    public function getPdf(): ResultObject
    {
        $this->resultObjectClass = ResultPdfObject::class;
        return $this->getString();
    }
}