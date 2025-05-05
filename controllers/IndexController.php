<?php

namespace app\controllers;

use app\models\VigenereEncoder;
use yii\web\Controller;

class IndexController extends Controller
{
    public function actionLab2Encode(string $key = null, string $text = null): string
    {
        if ($key && $text) {
            $model = new VigenereEncoder([
                'key' => $key,
                'text' => $text,
            ]);
            $encoded = $model->encode();
        }

        return $this->render('lab2-encode', [
            'model' => $model ?? null,
            'encoded' => $encoded ?? null,
        ]);
    }

    public function actionLab2Decode(string $key = null, string $text = null): string
    {
        if ($key && $text) {
            $model = new VigenereEncoder([
                'key' => $key,
                'text' => $text,
            ]);
            $encoded = $model->decode();
        }

        return $this->render('lab2-decode', [
            'model' => $model ?? null,
            'encoded' => $encoded ?? null,
        ]);
    }
}