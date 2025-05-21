<?php

namespace app\models;

use yii\base\Model;

class Lab4Model extends Model
{
    private array $squire = [
        16, 3, 2, 13,
        5, 10, 11, 8,
        9, 6, 7, 12,
        4, 15, 14, 1,
    ];
    private ?array $squireIndexes = null;
    private ?int $numberOfElements = null;

    public ?string $decoded;
    public ?string $encoded;

    public function rules()
    {
        return [
            [['encoded', 'decoded'], 'string', 'max' => $this->numberOfElements],
        ];
    }

    public function init()
    {
        $this->squireIndexes = array_flip($this->squire);
        $this->numberOfElements = count($this->squire);
    }

    public function encode(): void
    {
        $letters = mb_str_split($this->decoded);

        $result = '';
        foreach ($this->squire as $item) {
            $result .= $letters[$item - 1] ?? '.';
        }

        $this->encoded = $result;
    }

    public function decode(): void
    {
        $letters = mb_str_split($this->encoded);

        $result = [];
        foreach ($letters as $i => $letter) {
            $result[$this->squireIndexes[$i + 1]] = $letter;
        }
        $resultString = '';
        foreach ($result as $pair) {
            $resultString .= $this->squire[$pair['index']];
        }

        $this->decoded = $resultString;
    }
}
