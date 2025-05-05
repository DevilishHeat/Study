<?php

namespace app\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    public function actionEncode(string $key, string $text): string
    {
        $firstLetterCode = mb_ord('a');
        $lastLetterCode = mb_ord('z');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($key));
        $keyLength = strlen($key);
        $textChars = str_split($text, $keyLength);
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

    public function actionDecode(string $key, string $text): string
    {
        $firstLetterCode = mb_ord('a');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($key));
        $keyLength = strlen($key);
        $textChars = str_split($text, $keyLength);
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