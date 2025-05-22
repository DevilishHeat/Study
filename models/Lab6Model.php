<?php

namespace app\models;

use yii\base\Model;

class Lab6Model extends Model
{
    public ?string $text = null;
    public null|array|string $frequency = [];
    public ?string $encodedText = null;
    public null|array|string $encodedFrequency = [];
    private array $decodingArray = [];
    public ?string $textToDecode = null;
    public ?string $decodedText = null;

    public function init()
    {
        if (is_string($this->frequency)) {
            $this->frequency = [];
            $array = explode('_', $this->frequency);
            foreach ($array as $item) {
                if (!$item) {
                    continue;
                }
                list($letter, $frequency) = explode('-', $item);
                $this->frequency[$letter] = $frequency;
            }
        }

        if (is_string($this->encodedFrequency)) {
            $this->encodedFrequency = [];
            $array = explode('_', $this->encodedFrequency);
            foreach ($array as $item) {
                if (!$item) {
                    continue;
                }
                list($letter, $frequency) = explode('-', $item);
                $this->encodedFrequency[$letter] = $frequency;
            }
        }
    }

    public function calcFrequency($text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace("/[^а-я]+/u", "", $text);
        $letters = mb_str_split($text);

        $frequency = [];
        foreach ($letters as $letter) {
            if (!($frequency[$letter] ?? null)) {
                $frequency[$letter] = 0;
            }
            $frequency[$letter]++;
        }

        ksort($frequency);
        return $frequency;
    }

    public function serializeFrequency(array $frequency): string
    {
        if (!$frequency) {
            return '';
        }

        $result = '';

        foreach ($frequency as $letter => $item) {
            $result .= "$letter-{$item}_";
        }

        return $result;
    }

    private function createDecodingArray()
    {

    }

    public function decode()
    {

    }
}