<?php

namespace proleads\documents\models\generation\root\output;

use Yii;

class ResultHtmlObject extends ResultObject
{

    public function sendToBrowser(){

        Yii::$app->response->headers->set('Content-Type', 'text/html');
        Yii::$app->response->content = $this->getResult();
        Yii::$app->response->send();


    }

}