<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Helpers\ExchangeRateHelper;

class ExchangeRateHelperTest extends TestCase
{
    public function testGetExchangeRate()
    {
        $this->assertEquals(1, ExchangeRateHelperMock::getExchangeRate(ExchangeRateHelper::DEF_CURRENCY));
        $this->assertEquals(1.09, ExchangeRateHelperMock::getExchangeRate('USD'));
    }
}

class ExchangeRateHelperMock extends ExchangeRateHelper
{
    public static function getExchangeRatesFromAPI(string $currency)
    {
        $rates = [
            'EUR' => 1,
            'USD' => 1.09,
        ];

        return $rates[$currency];
    }
}