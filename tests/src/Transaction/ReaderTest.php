<?php

namespace Tests\Transaction;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Transaction\Reader;

class ReaderTest extends TestCase
{
    public function testReadData()
    {
        $mock = $this->getMockBuilder(Reader::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getFileData'])
            ->getMock();

        $mock
            ->expects($this->once())
            ->method('getFileData')
            ->willReturn([
                '{"bin":"45717360","amount":"100.00","currency":"EUR"}'
            ]);

        $mock->readData();

        $this->assertSame(
            [['bin' => '45717360', 'amount' => '100.00', 'currency' => 'EUR']],
            $mock->getData()
        );
    }
}