<?php

namespace app\controllers;

use app\models\Lab3Model;
use Yii;
use yii\web\Controller;

class IndexController extends Controller
{

    public function actionLab3()
    {
        $model = new Lab3Model();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->encode();
        }

        return $this->render('lab3', [
            'model' => $model,
            'encoded' => $model->encoded,
            'decoded' => $model->decoded,
        ]);
    }

    public function actionLab3Decode(): string
    {
        $model = new Lab3Model();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->decode();
        }

        return $this->render('lab3', [
            'model' => $model,
            'encoded' => $model->encoded,
            'decoded' => $model->decoded,
        ]);
    }
}