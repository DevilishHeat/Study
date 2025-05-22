<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\VarDumper;

class Lab3Model extends Model
{
    public ?string $key = null;
    public ?string $encoded = null;
    public ?string $decoded = null;
    private int $firstLetterCode;
    private int $lastLetterCode;
    private int $alphabetPower;

    public function rules()
    {
        return [
            [['key', 'encoded', 'decoded'], 'string'],
        ];
    }

    public function init()
    {
        $this->firstLetterCode = mb_ord('а');
        $this->lastLetterCode = mb_ord('я');
        $this->alphabetPower = $this->lastLetterCode - $this->firstLetterCode + 1;
    }

    public function encode(): void
    {
        $keyChars = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, mb_str_split($this->key));
        $keyLength = mb_strlen($this->key);
        $textChunks = mb_str_split($this->decoded, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = mb_str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) + $keyChars[$j];
                $newChar = $newCharCode <= $this->lastLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode - $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $keyChars = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, mb_str_split($this->key));
        $keyLength = mb_strlen($this->key);
        $textChunks = mb_str_split($this->encoded, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = mb_str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) - $keyChars[$j];
                $newChar = $newCharCode >= $this->firstLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode + $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->decoded = $result;
    }
}