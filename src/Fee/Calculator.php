<?php
declare(strict_types=1);

namespace TransFeeCalc\Fee;

use TransFeeCalc\Transaction\DTO\Transaction;

class Calculator
{
    public function calculate(Transaction $transaction): float
    {
        return round(($transaction->getAmount() / $transaction->getRate()) * $transaction->getRatio(), 2);
    }
}