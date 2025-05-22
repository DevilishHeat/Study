<?php

namespace app\models;

use yii\base\Model;

class Lab6Model extends Model
{
    public ?string $text = null;
    public array $frequency = [];
    public ?string $encodedText = null;
    public array $encodedFrequency = [];
    private array $decodingArray = [];
    public ?string $textToDecode = null;
    public ?string $decodedText = null;

    public function calcFrequency(): void
    {

    }

    public function calcEncodedFrequency()
    {

    }

    private function createDecodingArray()
    {

    }

    public function decode()
    {

    }
}