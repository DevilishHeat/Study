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
        $this->text = mb_strtolower($this->text);
        $this->text = preg_replace("/[^a-z]+/", "", $this->text);
        $letters = mb_str_split($this->text);

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
        $this->encodedText = mb_strtolower($this->encodedText);
        $this->encodedText = preg_replace("/[^a-z]+/", "", $this->encodedText);
        $letters = mb_str_split($this->encodedText);

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