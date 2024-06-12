<?php

namespace TransFeeCalc\Transaction\Facade;

use TransFeeCalc\Fee\Calculator;
use TransFeeCalc\Fee\Ratio;
use TransFeeCalc\Helpers\CardHelper;
use TransFeeCalc\Helpers\ExchangeRateHelper;
use TransFeeCalc\Transaction\DTO\Transaction;
use TransFeeCalc\Transaction\Reader;

class Processor
{
    public function __construct(
        private Reader $reader
    )
    {
    }

    public function getResult(): \Generator
    {
        foreach ($this->reader->getFileData() as $row)
        {
            $dto = new Transaction($row['bin'], $row['amount'], $row['currency']);
            $dto->setIsEU($this->isEU($dto->getBin()));
            $dto->setRate($this->getExchangeRateByCurrency($dto->getCurrency()));
            $dto->setRatio((new Ratio())->getRatio($dto));

            yield (new Calculator())->calculate($dto);
        }
    }

    /**
     * @param string $binCode
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function isEU(string $binCode): bool
    {
        return CardHelper::isEuAssociated(CardHelper::getCountryCodeByBin($binCode));
    }

    /**
     * @param string $currency
     * @return mixed
     * @throws \Exception
     */
    protected function getExchangeRateByCurrency(string $currency): mixed
    {
        return ExchangeRateHelper::getExchangeRate($currency);
    }
}