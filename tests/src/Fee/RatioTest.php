<?php

namespace Tests\Fee;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Fee\Ratio;
use TransFeeCalc\Transaction\DTO\Transaction;

class RatioTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param Transaction $transaction
     * @param bool $isEU
     * @param float $expected
     * @return void
     */
    public function testGetRatio(Transaction $transaction, bool $isEU, float $expected)
    {
        $transaction->setIsEU($isEU);

        $this->assertEquals($expected, (new Ratio())->getRatio($transaction));
    }

    /**
     * @return array[]
     */
    public static function dataProvider(): array
    {
        return [
            [
                'transaction' => (new Transaction('123456', 100, 'EUR')),
                'isEU' => true,
                'expected' => Ratio::EU_RATIO,
            ],
            [
                'transaction' => (new Transaction('123456', 100, 'EUR')),
                'isEU' => false,
                'expected' => Ratio::DEFAULT_RATIO,
            ]
        ];
    }
}