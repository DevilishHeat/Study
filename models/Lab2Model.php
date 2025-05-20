<?php

namespace app\models;

use yii\base\Model;

class Lab2Model extends Model
{
    public ?string $encoded = null;
    public ?string $decoded = null;
    private int $firstLetterCode;
    private int $lastLetterCode;
    private int $alphabetPower;

    public function init()
    {
        $this->firstLetterCode = mb_ord('а');
        $this->lastLetterCode = mb_ord('я');
        $this->alphabetPower = $this->lastLetterCode - $this->firstLetterCode;
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
            $newChar = mb_chr($this->alphabetPower - mb_ord($letter) + 1);
            $result .= $newChar;
        }

        $this->decoded = $result;
    }
}