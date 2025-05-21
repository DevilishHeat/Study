<?php

namespace app\controllers;

use app\models\Lab2Model;
use app\models\Lab3Model;
use app\models\Lab4Model;
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
        ]);
    }

    public function actionLab2()
    {
        $model = new Lab2Model(Yii::$app->request->post('Lab2Model') ?? []);

        if ($model->decoded) {
            $model->encode();
        }

        return $this->render('lab2', [
            'model' => $model,
        ]);
    }

    public function actionLab2Decode()
    {
        $model = new Lab2Model(Yii::$app->request->post('Lab2Model') ?? []);

        if ($model->encoded) {
            $model->decode();
        }

        return $this->render('lab2', [
            'model' => $model,
        ]);
    }

    public function actionLab4()
    {
        $model = new Lab4Model(Yii::$app->request->post('Lab4Model') ?? []);

        if ($model->decoded && $model->validate()) {
            $model->encode();
        }

        return $this->render('lab4', [
            'model' => $model,
        ]);
    }


    public function actionLab4Decode()
    {
        $model = new Lab4Model(Yii::$app->request->post('Lab4Model') ?? []);

        if ($model->encoded) {
            $model->decode();
        }

        return $this->render('lab4', [
            'model' => $model,
        ]);
    }
}