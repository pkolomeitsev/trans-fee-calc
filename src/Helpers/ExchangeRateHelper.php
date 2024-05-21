<?php

namespace TransFeeCalc\Helpers;

class ExchangeRateHelper
{
    const DEF_CURRENCY = 'EUR';

    /**
     * Mock the rates
     * @var array
     */
    private static array $defRates = [
        'rates' => [
            'EUR' => 1,
            'USD' => 1.09,
            'JPY' => 169.53,
            'GBP' => 0.85,
        ]
    ];

    /**
     * @param string $currency
     * @return int|mixed
     * @throws \Exception
     */
    public static function getExchangeRate(string $currency)
    {
        if ($currency == self::DEF_CURRENCY) {
            return 1;
        }

        return static::getExchangeRatesFromAPI($currency);
    }

    /**
     * @param string $currency
     * @return mixed
     * @throws \Exception
     */
    public static function getExchangeRatesFromAPI(string $currency)
    {
        $rates = file_get_contents('https://api.exchangeratesapi.io/latest');
        if (!$rates) {
            throw new \Exception('Cannot get date from Exchange Rates service');
        }

        $rates = json_decode($rates, true) ?? [];
        if (empty($rates['rates'][$currency]) || (!$rate = $rates['rates'][$currency])) {
            // Don't have API service registration, then use mock data instead
            if (!$rate = self::$defRates['rates'][$currency]) {
                throw new \Exception(sprintf('Can\'t get exchange rate for %s currency', $currency));
            }
        }

        return $rate;
    }
}