<?php

namespace app\models;

use yii\base\Model;

class Lab2Model extends Model
{
    public ?string $encoded = null;
    public ?string $decoded = null;
    private int $firstLetterCode;
    private int $lastLetterCode;

    public function init()
    {
        $this->firstLetterCode = mb_ord('А');
        $this->lastLetterCode = mb_ord('я');
    }

    public function encode(): void
    {
        $letters = mb_str_split($this->decoded);
        $result = '';
        foreach ($letters as $letter) {
            $newChar = mb_chr($this->lastLetterCode - mb_ord($letter)  + $this->firstLetterCode);
            $result .= $newChar;
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $letters = mb_str_split($this->encoded);
        $result = '';
        foreach ($letters as $letter) {
            $newChar = mb_chr($this->lastLetterCode - mb_ord($letter)  + $this->firstLetterCode);
            $result .= $newChar;
        }

        $this->decoded = $result;
    }
}