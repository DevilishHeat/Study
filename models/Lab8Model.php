<?php

namespace app\models;

use yii\base\Model;

class Lab8Model extends Model
{
    public ?int $q = null;
    public ?int $p = null;
    public ?int $d = null;
    public ?int $n = null;
    public ?int $e = null;
    private ?int $phiN = null;

    public function generateKeys()
    {
        $this->n = $this->q * $this->p;
        $this->phiN = ($this->q - 1) * ($this->p - 1);
        for ($i = 2; $i < $this->phiN; $i++) {
            if ($this->phiN % $i != 0) {
                if (gmp_prob_prime($i, $this->phiN) == 2) {
                    $this->e = $i;
                    break;
                }
            }
        }
        $this->d = $this->findD($this->e, $this->phiN);
    }

    /**
     * Расширенный алгоритм Евклида
     */
    private function findD(int $a, int $b): int
    {
        $x1 = 0;
        $x2 = 1;
        $y1 = 1;
        $y2 = 0;

        while ($b > 0) {
            $q = intdiv($a, $b);
            $r = $a - $q * $b;
            $x = $x2 - $q * $x1;
            $y = $y2 - $q * $y1;
            $a = $b;
            $b = $r;
            $x2 = $x1;
            $x1 = $x;
            $y2 = $y1;
            $y1 = $y;
        }

        return $this->phiN - abs(min($x2, $y2));
    }
}