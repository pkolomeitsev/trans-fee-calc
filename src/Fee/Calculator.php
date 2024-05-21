<?php

namespace TransFeeCalc\Fee;

use TransFeeCalc\Helpers\CardHelper;
use TransFeeCalc\Helpers\ExchangeRateHelper;
use TransFeeCalc\Transaction\DTO\Transaction;

class Calculator
{
    private array $result = [];
    public function __construct(
        private readonly array $transactions
    )
    {
    }

    public function calculate(): static
    {
        foreach ($this->transactions as $transaction) {
            if (!($transaction instanceof Transaction)) {
                continue;
            }
            $amount = $transaction->getAmount();
            $isEU = $this->isEU($transaction->getBin());
            $rate = $this->getExchangeRateByCurrency($transaction->getCurrency());

            $this->result[] = round(($amount / $rate) * (($isEU) ? 0.01 : 0.02), 2);
        }

        return $this;
    }

    /**
     * @param string $binCode
     * @return bool
     */
    public function isEU(string $binCode): bool
    {
        return CardHelper::isEuAssociated(CardHelper::getCountryCodeByBin($binCode));
    }

    /**
     * @param string $currency
     * @return int|mixed
     */
    public function getExchangeRateByCurrency(string $currency)
    {
        return ExchangeRateHelper::getExchangeRate($currency);
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    public function __toString(): string
    {
        return implode(PHP_EOL, $this->result);
    }
}