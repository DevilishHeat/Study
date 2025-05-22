<?php

namespace app\controllers;

use app\models\Lab2Model;
use app\models\Lab3Model;
use app\models\Lab4Model;
use app\models\Lab6Model;
use app\models\Lab8Model;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class IndexController extends Controller
{

    public function actionLab3()
    {
        $model = new Lab3Model(Yii::$app->request->post('Lab3Model') ?? []);

        if ($model->validate() && $model->key && $model->decoded) {
            $model->encode();
        }

        return $this->render('lab3', [
            'model' => $model,
        ]);
    }

    public function actionLab3Decode(): string
    {
        $model = new Lab3Model(Yii::$app->request->post('Lab3Model') ?? []);

        if ($model->validate() && $model->key && $model->encoded) {
            $model->decode();
        }

        return $this->render('lab3', [
            'model' => $model,
        ]);
    }

    public function actionLab2()
    {
        $model = new Lab2Model(Yii::$app->request->post('Lab2Model') ?? []);

        if ($model->validate() && $model->decoded) {
            $model->encode();
        }

        return $this->render('lab2', [
            'model' => $model,
        ]);
    }

    public function actionLab2Decode()
    {
        $model = new Lab2Model(Yii::$app->request->post('Lab2Model') ?? []);

        if ($model->validate() && $model->encoded) {
            $model->decode();
        }

        return $this->render('lab2', [
            'model' => $model,
        ]);
    }

    public function actionLab4()
    {
        $model = new Lab4Model(Yii::$app->request->post('Lab4Model') ?? []);

        if ($model->validate() && $model->decoded) {
            $model->encode();
        }

        return $this->render('lab4', [
            'model' => $model,
        ]);
    }


    public function actionLab4Decode()
    {
        $model = new Lab4Model(Yii::$app->request->post('Lab4Model') ?? []);

        if ($model->validate() && $model->encoded) {
            $model->decode();
        }

        return $this->render('lab4', [
            'model' => $model,
        ]);
    }

    public function actionLab6()
    {
        $model = new Lab6Model(Yii::$app->request->post('Lab6Model') ?? []);

        if ($model->validate() && $model->text) {
            $model->frequency = $model->calcFrequency($model->text);
        }

        return $this->render('lab6', [
            'model' => $model,
        ]);
    }

    public function actionLab6EncodedFrequency()
    {
        $model = new Lab6Model(Yii::$app->request->post('Lab6Model') ?? []);

        if ($model->validate() && $model->encodedText) {
            $model->encodedFrequency = $model->calcFrequency($model->encodedText);
        }

        return $this->render('lab6', [
            'model' => $model,
        ]);
    }

    public function actionLab6Decode()
    {
        $model = new Lab6Model(Yii::$app->request->post('Lab6Model') ?? []);

        if ($model->validate() && $model->textToDecode) {
            $model->decode();
        }

        return $this->render('lab6', [
            'model' => $model,
        ]);
    }

    public function actionLab8()
    {
        $model = new Lab8Model(Yii::$app->request->post('Lab8Model') ?? []);

        if ($model->validate() && $model->q && $model->p) {
            $model->generateKeys();
        }

        return $this->render('lab8', [
            'model' => $model,
        ]);
    }
}