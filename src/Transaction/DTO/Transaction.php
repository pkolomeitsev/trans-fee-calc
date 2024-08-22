<?php
declare(strict_types=1);

namespace TransFeeCalc\Transaction\DTO;

class Transaction
{
    private bool $isEU;
    private float $rate;
    private float $ratio;

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

    public function isEU(): bool
    {
        return $this->isEU;
    }

    public function setIsEU(bool $isEU): void
    {
        $this->isEU = $isEU;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }

    public function setRatio(float $ratio): void
    {
        $this->ratio = $ratio;
    }

}