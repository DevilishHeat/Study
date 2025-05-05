<?php

namespace app\models;

use yii\base\Model;

class VigenereEncoder extends Model
{
    public string $key;
    public string $text;
    public function encode(): string
    {
        $firstLetterCode = mb_ord('a');
        $lastLetterCode = mb_ord('z');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChars = str_split($this->text, $keyLength);
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

        return $result;
    }

    public function decode()
    {
        $firstLetterCode = mb_ord('a');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->key));
        $keyLength = strlen($this->key);
        $textChars = str_split($this->text, $keyLength);
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

        return $result;
    }
}