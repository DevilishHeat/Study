<?php

namespace app\controllers;

use yii\web\Controller;

class StudentController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}