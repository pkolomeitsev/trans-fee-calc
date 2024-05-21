<?php

namespace TransFeeCalc\Helpers;
class CardHelper
{
    private static array $euAssociated = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
        'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
        'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
    ];

    /**
     * Check if country code is associated with EU
     * @param string $countryCode
     * @return bool
     */
    public static function isEuAssociated(string $countryCode): bool
    {
        return in_array($countryCode, self::$euAssociated);
    }

    /**
     * @param string $binCode
     * @return string
     */
    public static function getCountryCodeByBin(string $binCode): string
    {
        $binLookup = static::getLookupData($binCode);

        return $binLookup['country']['alpha2'] ?? '';
    }

    /**
     * @param string $binCode
     * @return array
     */
    public static function getLookupData(string $binCode): array
    {
        $binLookup = file_get_contents('https://lookup.binlist.net/' . $binCode);
        sleep(3); // Failed to open stream: HTTP request failed! HTTP/1.1 429 Too Many Requests
        if (!$binLookup) {
            return [];
        }
        return json_decode($binLookup, true);
    }
}