<?php

namespace Tests\Fee;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Fee\Calculator;
use TransFeeCalc\Transaction\DTO\Transaction;


class CalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @return void
     */
    public function testAggregate($transaction, $isEU, $rate, $fee)
    {
        $data = [$transaction];

        $mock = $this->getMockBuilder(Calculator::class)
            ->setConstructorArgs([$data])
            ->onlyMethods(['isEU', 'getExchangeRateByCurrency'])
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('isEU')
            ->willReturn($isEU);

        $mock
            ->expects($this->any())
            ->method('getExchangeRateByCurrency')
            ->willReturn($rate);

        $mock->calculate();

        $this->assertSame(
            $fee,
            $mock->getResult()
        );
    }

    public static function dataProvider(): array
    {
        return [
            [
                'transaction' => (new Transaction('123456', 100, 'EUR')),
                'isEU' => true,
                'rate' => 1,
                'fee' => [1.0]
            ],
            [
                'transaction' => (new Transaction('123456', 100, 'USD')),
                'isEU' => false,
                'rate' => 1.01,
                'fee' => [1.98]
            ],
            [
                'transaction' => [],
                'isEU' => false,
                'rate' => 1.01,
                'fee' => []
            ],
        ];
    }
}