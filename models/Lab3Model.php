<?php

namespace app\models;

use yii\base\Model;

class Lab3Model extends Model
{
    public string $key;
    public ?string $encoded = null;
    public ?string $decoded = null;
    public function encode(): void
    {
        $firstLetterCode = mb_ord('a');
        $lastLetterCode = mb_ord('z');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChars = str_split($this->decoded, $keyLength);
        $result = '';
        foreach ($textChars as $textChar) {
            $textChar = str_split($textChar);
            foreach ($textChar as $j => $char) {
                if (($newCharCode = mb_ord($char) + $keyChar[$j]) <= $lastLetterCode) {
                    $newChar = mb_chr($newCharCode);
                } else {
                    $newChar = mb_chr($newCharCode - 26);
                }
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
        $textChars = str_split($this->encoded, $keyLength);
        $result = '';
        foreach ($textChars as $textChar) {
            $textChar = str_split($textChar);
            foreach ($textChar as $j => $char) {
                if (($newCharCode = mb_ord($char) - $keyChar[$j]) >= $firstLetterCode) {
                    $newChar = mb_chr($newCharCode);
                } else {
                    $newChar = mb_chr($newCharCode + 26);
                }
                $result .= $newChar;
            }
        }

        $this->decoded = $result;
    }
}