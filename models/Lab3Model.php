<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\VarDumper;

class Lab3Model extends Model
{
    public ?string $key = null;
    public ?string $encoded = null;
    public ?string $decoded = null;

    private ?string $keyASCII = null;
    private ?string $encodedASCII = null;
    private ?string $decodedASCII = null;

    public function init()
    {
        $this->keyASCII = mb_convert_encoding($this->key, 'ASCII');
        $this->decodedASCII = mb_convert_encoding($this->decoded, 'ASCII');
        $this->encodedASCII = mb_convert_encoding($this->encoded, 'ASCII');
    }

    public function encode(): void
    {
        $firstLetterCode = mb_ord(' ');
        $lastLetterCode = mb_ord('z');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->keyASCII));
        $keyLength = strlen($this->keyASCII);
        $textChunks = str_split($this->decodedASCII, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) + $keyChar[$j];
                $newChar = $newCharCode <= $lastLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode - 26);
                $result .= $newChar;
            }
        }

        $this->encoded = mb_convert_encoding($result, 'UTF-8');
    }

    public function decode(): void
    {
        $firstLetterCode = mb_ord(' ');
        $keyChar = array_map(fn ($char) => mb_ord($char) - $firstLetterCode, str_split($this->keyASCII));
        $keyLength = strlen($this->keyASCII);
        $textChunks = str_split($this->encodedASCII, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) - $keyChar[$j];
                $newChar = $newCharCode >= $firstLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode + 26);
                $result .= $newChar;
            }
        }

        $this->decoded = mb_convert_encoding($result, 'UTF-8');
    }
}