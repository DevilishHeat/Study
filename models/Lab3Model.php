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
    private int $firstLetterCode;
    private int $lastLetterCode;
    private int $alphabetPower;

    public function init()
    {
        $this->keyASCII = mb_convert_encoding($this->key, 'UTF-8');
        $this->decodedASCII = mb_convert_encoding($this->decoded, 'UTF-8');
        $this->encodedASCII = mb_convert_encoding($this->encoded, 'UTF-8');
        $this->firstLetterCode = mb_ord(' ');
        $this->lastLetterCode = mb_ord('z');
        $this->alphabetPower = $this->lastLetterCode - $this->firstLetterCode;
    }

    public function encode(): void
    {
        $keyChar = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, str_split($this->keyASCII));
        $keyLength = strlen($this->keyASCII);
        $textChunks = str_split($this->decodedASCII, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) + $keyChar[$j];
                $newChar = $newCharCode <= $this->lastLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode - $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->encoded = mb_convert_encoding($result, mb_detect_encoding($this->key));
    }

    public function decode(): void
    {
        $keyChar = array_map(fn ($char) => mb_ord($char) - $this->firstLetterCode, str_split($this->keyASCII));
        $keyLength = strlen($this->keyASCII);
        $textChunks = str_split($this->encodedASCII, $keyLength);
        $result = '';
        foreach ($textChunks as $textChunk) {
            $textChunk = str_split($textChunk);
            foreach ($textChunk as $j => $char) {
                $newCharCode = mb_ord($char) - $keyChar[$j];
                $newChar = $newCharCode >= $this->firstLetterCode ? mb_chr($newCharCode) : mb_chr($newCharCode + $this->alphabetPower);
                $result .= $newChar;
            }
        }

        $this->decoded = mb_convert_encoding($result, mb_detect_encoding($this->key));
    }
}