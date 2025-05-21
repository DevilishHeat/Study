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
    private ?int $numberOfElements = null;

    public ?string $decoded = null;
    public ?string $encoded = null;

    public function rules()
    {
        return [
            [['encoded', 'decoded'], 'string', 'max' => $this->numberOfElements],
        ];
    }

    public function init()
    {
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
        $letters = mb_str_split($this->encoded, true);
        asort($this->squire);

        $result = '';
        foreach ($this->squire as $index => $item) {
            $result .= $letters[$index] ?? '';
        }

        $this->decoded = $result;
    }
}
