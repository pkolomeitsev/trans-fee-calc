<?php

namespace TransFeeCalc\Transaction\DTO;

class Transaction
{

    /**
     * @param string $bin
     * @param float $amount
     * @param string $currency
     */
    public function __construct(
        private string $bin,
        private float  $amount,
        private string $currency,
    )
    {
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function setBin(string $bin): void
    {
        $this->bin = $bin;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

}