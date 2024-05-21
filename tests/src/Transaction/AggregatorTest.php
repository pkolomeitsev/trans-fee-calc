<?php

namespace Tests\Transaction;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Transaction\Aggregator;
use TransFeeCalc\Transaction\DTO\Transaction;

class AggregatorTest extends TestCase
{
    public function testAggregate()
    {
        $data = [
            ['bin' => '123456', 'amount' => 100, 'currency' => 'EUR'],
            ['bin2' => '123456', 'amount2' => 100, 'currency2' => 'EUR'],
            []
        ];

        $coll = (new Aggregator($data))->aggregate()->getCollection();

        $this->assertCount(1, $coll);
        $this->assertTrue($coll[0] instanceof Transaction);
    }
}