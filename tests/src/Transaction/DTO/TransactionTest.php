<?php

namespace Tests\Transaction\DTO;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Transaction\DTO\Transaction;

class TransactionTest extends TestCase
{
    public function testBasics()
    {
        $bin = '12345';
        $amount = 50;
        $currency = 'EUR';
        $dto = new Transaction($bin, $amount, $currency);

        $this->assertEquals($bin, $dto->getBin());
        $this->assertEquals($amount, $dto->getAmount());
        $this->assertEquals($currency, $dto->getCurrency());

        $bin = '54321';
        $amount = 1000;
        $currency = 'GBP';

        $dto->setBin($bin);
        $dto->setAmount($amount);
        $dto->setCurrency($currency);

        $this->assertEquals($bin, $dto->getBin());
        $this->assertEquals($amount, $dto->getAmount());
        $this->assertEquals($currency, $dto->getCurrency());
    }
}