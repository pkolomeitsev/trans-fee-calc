<?php

namespace Tests\Fee;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Fee\Calculator;
use TransFeeCalc\Fee\Ratio;
use TransFeeCalc\Transaction\DTO\Transaction;

class CalculatorTest extends TestCase
{

    private Calculator $feeCalculator;

    protected function setUp(): void
    {
        $this->feeCalculator = new Calculator();
    }

    /**
     * @dataProvider dataProvider
     *
     * @param Transaction $transaction
     * @param float $rate
     * @param float $ratio
     * @param $expected
     * @return void
     */
    public function testCalculate(Transaction $transaction, float $rate, float $ratio, $expected): void
    {
        $transaction->setRatio($ratio);
        $transaction->setRate($rate);

        $this->assertEquals($expected, $this->feeCalculator->calculate($transaction));
    }

    public static function dataProvider(): array
    {
        return [
            [
                'transaction' => (new Transaction('123456', 100, 'EUR')),
                'rate' => 1,
                'ratio' => Ratio::DEFAULT_RATIO,
                'expected' => 2,
            ],
            [
                'transaction' => (new Transaction('123456', 100, 'EUR')),
                'rate' => 0.5,
                'ratio' => Ratio::EU_RATIO,
                'expected' => 2,
            ]
        ];
    }
}