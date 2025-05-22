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

    public function rules(): array
    {
        return [
            [['text', 'encodedText', 'decodedText'], 'string'],
        ];
    }

    public function init()
    {
        if (is_string($this->frequency)) {
            $this->frequency = $this->deserializeFrequency($this->frequency);
        }

        if (is_string($this->encodedFrequency)) {
            $this->encodedFrequency = $this->deserializeFrequency($this->encodedFrequency);
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

        arsort($frequency);
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
        $frequency = array_keys($this->frequency);
        $encodedFrequency = array_keys($this->encodedFrequency);
        for ($i = 0; $i < min(count($encodedFrequency), count($frequency)); $i++) {
            $this->decodingArray[$encodedFrequency[$i]] = $frequency[$i];
        }
    }

    public function decode()
    {
        $this->createDecodingArray();
        $text = mb_strtolower($this->textToDecode);
        $letters = mb_str_split($text);
        $result = '';

        foreach ($letters as $letter) {
            $result .= $this->decodingArray[$letter] ?? '&';
        }

        $this->decodedText = $result;
    }

    private function deserializeFrequency(array|string|null $frequency): array
    {
        $array = explode('_', $frequency);
        $result = [];
        foreach ($array as $item) {
            if (!$item) {
                continue;
            }
            list($letter, $frequency) = explode('-', $item);
            $result[$letter] = $frequency;
        }

        return $result;
    }
}