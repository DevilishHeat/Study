<?php

namespace app\models;

use yii\base\Model;

/**
 * Шифр Атбаш
 */
class Lab2Model extends Model
{
    public ?string $encoded = null;
    public ?string $decoded = null;
    private int $firstLetterCode;
    private int $lastLetterCode;

    public function init()
    {
        $this->firstLetterCode = mb_ord('а');
        $this->lastLetterCode = mb_ord('я');
    }

    public function rules()
    {
        return [
            [['encoded', 'decoded'], 'string'],
        ];
    }

    public function encode(): void
    {
        $text = mb_strtolower($this->decoded);
        $text = preg_replace("/[^а-я]+/u", "", $text);
        $letters = mb_str_split($text);
        $result = '';
        foreach ($letters as $letter) {
            $newChar = mb_chr($this->lastLetterCode - mb_ord($letter)  + $this->firstLetterCode);
            $result .= $newChar;
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $text = mb_strtolower($this->encoded);
        $text = preg_replace("/[^а-я]+/u", "", $text);
        $letters = mb_str_split($text);
        $result = '';
        foreach ($letters as $letter) {
            $newChar = mb_chr($this->lastLetterCode - mb_ord($letter)  + $this->firstLetterCode);
            $result .= $newChar;
        }

        $this->decoded = $result;
    }
}