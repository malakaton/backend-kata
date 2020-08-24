<?php

declare(strict_types=1);

namespace App\libs;

final class SpecialSum
{
    private int $k;
    private int $n;

    public function __construct(int $k, int $n)
    {
        $this->isPositiveValue($k);
        $this->isPositiveValue($n);

        $this->k = $k;
        $this->n = $n;
    }

    /**
     * @param int $value
     * @throws \RuntimeException
     */
    private function isPositiveValue(int $value): void
    {
        if (is_numeric($value) && $value < 0) {
            throw new \RuntimeException("Value {$value} must be positive");
        }
    }

    public function __invoke(): string
    {
        $combination = array();

        for ($kCounter = 0; $kCounter <= $this->k - 1; $kCounter++) {
            for ($nCounter = 1; $nCounter <= $this->n; $nCounter++) {
                $combination[$kCounter][$nCounter] = $this->calculator($kCounter, $nCounter, $combination);
            }
        }

        return $this->getResult($this->k, $combination);
    }

    private function calculator(int $k, int $n, array $combination): float
    {
        if ($k === 0) {
            return $n;
        }
        if ($n === 1) {
            return 1;
        }

        return round(($combination[$k-1][$n] + $combination[$k][$n - 1]), 0);
    }

    private function getResult(int $k, array $combination): string
    {
        $sum = 0;

        foreach ($combination[$k - 1] as $value) {
            $sum += round($value, 0);
        }

        return number_format($sum, 0, '', '');
    }
}