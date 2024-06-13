<?php

namespace TransFeeCalc\Fee;

use TransFeeCalc\Transaction\DTO\Transaction;

class Ratio
{
    const DEFAULT_RATIO = 0.02;
    const EU_RATIO = 0.01;

    public function getRatio(Transaction $transaction)
    {
        return (($transaction->isEU()) ? self::EU_RATIO : self::DEFAULT_RATIO);
    }
}