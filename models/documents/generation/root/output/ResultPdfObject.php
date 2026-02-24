<?php

namespace proleads\documents\models\generation\root\output;

use proleads\documents\models\generation\root\output\ResultObject;
use Yii;

class ResultPdfObject extends ResultObject
{

    public function sendToBrowser($fileName = 'test_pdf.pdf'){
        Yii::$app->response->sendContentAsFile($this->result, $fileName, [
            'inline' => true,
            'mimeType' => 'application/pdf'
        ]);
        Yii::$app->response->send();
    }
}