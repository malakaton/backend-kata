<?php

declare(strict_types=1);

namespace App\Tests;

use App\libs\SpecialSum;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class SpecialSumFeatureTest extends KernelTestCase
{
    private array $simulation;

    public function setUp(): void
    {
        parent::setUp();

        $this->simulation = [
            [
                'k' => 1,
                'n' => 3,
                'result' => '6'
            ],
            [
                'k' => 2,
                'n' => 3,
                'result' => '10'
            ],
            [
                'k' => 4,
                'n' => 10,
                'result' => '2002'
            ],
            [
                'k' => 10,
                'n' => 10,
                'result' => '167960'
            ],
            [
                'k' => 20,
                'n' => 20,
                'result' => '131282408400'
            ],
            [
                'k' => 30,
                'n' => 30,
                'result' => '114449595062769120'
            ],
            [
                'k' => 100,
                'n' => 100,
                'result' => '89651994709013159455763624700918514115268004601926720159744'
            ]
        ];
    }

    /**
     * @test
     */
    public function special_sum_should_works(): void
    {
        foreach($this->simulation as $simulate) {
            $result = (new SpecialSum($simulate['k'], $simulate['n']))->__invoke();
            echo "k = {$simulate['k']}, n = {$simulate['n']} => {$result} \n";
            self::assertEquals($simulate['result'], $result);
        }
    }
}