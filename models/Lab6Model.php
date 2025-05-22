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
        $text = mb_strtolower($this->text);
        $text = preg_replace("/[^а-я]+/", "", $text);
        $letters = mb_str_split($text);

        foreach ($letters as $letter) {
            if (!($this->frequency[$letter] ?? null)) {
                $this->frequency[$letter] = 0;
            }
            $this->frequency[$letter]++;
        }

        ksort($this->frequency);
    }

    public function calcEncodedFrequency()
    {
        $text = mb_strtolower($this->encodedText);
        $text = preg_replace("/[^а-я]+/", "", $text);
        $letters = mb_str_split($text);

        foreach ($letters as $letter) {
            if (!($this->encodedFrequency[$letter] ?? null)) {
                $this->encodedFrequency[$letter] = 0;
            }
            $this->encodedFrequency[$letter]++;
        }

        ksort($this->encodedFrequency);
    }

    private function createDecodingArray()
    {

    }

    public function decode()
    {

    }
}