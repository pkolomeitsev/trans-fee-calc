<?php

namespace Tests\Facade;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Fee\Ratio;
use TransFeeCalc\Transaction\DTO\Transaction;
use TransFeeCalc\Transaction\Facade\Processor;
use TransFeeCalc\Transaction\Reader;

class ProcessorTest extends TestCase
{
    private $readerMock;
    private $processorMock;

    protected function setUp(): void
    {
        $this->readerMock = $this->getMockBuilder(Reader::class)
            ->disableOriginalConstructor()
            ->disableAutoReturnValueGeneration()
            ->onlyMethods(['getFileData'])
            ->getMock();

        $this->processorMock = $this->getMockBuilder(Processor::class)
            ->setConstructorArgs([$this->readerMock])
            ->onlyMethods(['isEU', 'getExchangeRateByCurrency'])
            ->getMock();
    }


    /**
     * @dataProvider dataProvider
     */
    public function testGetResult(array $data, bool $isEU, float $rate, float $expected)
    {
        $this->readerMock
            ->expects($this->once())
            ->method('getFileData')
            ->willReturn($this->generate($data));

        $this->processorMock
            ->expects($this->once())
            ->method('isEU')
            ->willReturn($isEU);

        $this->processorMock
            ->expects($this->once())
            ->method('getExchangeRateByCurrency')
            ->willReturn($rate);

        foreach ($this->processorMock->getResult() as $value) {
            $this->assertSame($expected, $value);
        }

    }

    /**
     * @return array[]
     */
    public static function dataProvider(): array
    {
        return [
            [
                'data' => ['bin' => '1234', 'amount' => 100, 'currency' => 'EUR'],
                'isEU' => true,
                'rate' => 0.75,
                'expected' => 1.33,
            ],
            [
                'data' => ['bin' => '1234', 'amount' => 100, 'currency' => 'EUR'],
                'isEU' => false,
                'rate' => 0.25,
                'expected' => 8,
            ]
        ];
    }

    /**
     * Generator helper for mocked methods
     * @param array $data
     * @return \Generator
     */
    protected function generate(array $data): \Generator
    {
        yield $data;
    }
}