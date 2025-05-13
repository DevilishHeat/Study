<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\VarDumper;

class Lab3Model extends Model
{
    public ?string $key = null;
    public ?string $encoded = null;
    public ?string $decoded = null;
    public function encode(): void
    {
        $firstLetterCode = mb_ord('a');
        $lastLetterCode = mb_ord('z');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChunks = str_split($this->decoded, $keyLength);
        $result = '';
        VarDumper::dump($textChunks);
        exit();
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) + $keyChar[$j];
                $newChar = $newCharCode <= $lastLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode - 26);
                $result .= $newChar;
            }
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $firstLetterCode = mb_ord('a');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChunks = str_split($this->encoded, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) - $keyChar[$j];
                $newChar = $newCharCode >= $firstLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode + 26);
                $result .= $newChar;
            }
        }

        $this->decoded = $result;
    }
}