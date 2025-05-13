<?php

namespace app\controllers;

use app\models\Lab3Model;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class IndexController extends Controller
{

    public function actionLab3()
    {
        $model = new Lab3Model(Yii::$app->request->post('Lab3Model') ?? []);

        if ($model->key && $model->decoded) {
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
        $model = new Lab3Model(Yii::$app->request->post('Lab3Model') ?? []);

        if ($model->key && $model->encoded) {
            $model->decode();
        }

        return $this->render('lab3', [
            'model' => $model,
            'encoded' => $model->encoded,
            'decoded' => $model->decoded,
        ]);
    }
}