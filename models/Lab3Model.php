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

    public function init()
    {
        $this->firstLetterCode = mb_ord(' ');
        $this->lastLetterCode = mb_ord('z');
        $this->alphabetPower = $this->lastLetterCode - $this->firstLetterCode;
    }

    public function encode(): void
    {
        $keyChar = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChunks = str_split($this->decoded, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) + $keyChar[$j];
                $newChar = $newCharCode <= $this->lastLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode - $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $keyChar = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChunks = str_split($this->encoded, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) - $keyChar[$j];
                $newChar = $newCharCode >= $this->firstLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode + $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->decoded = $result;
    }
}