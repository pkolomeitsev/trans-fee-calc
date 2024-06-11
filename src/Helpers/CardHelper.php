<?php

namespace TransFeeCalc\Helpers;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function getCountryCodeByBin(string $binCode): string
    {
        $cache = new FilesystemAdapter();

        $key = sprintf('card-country-code-%s', $binCode);
        $countryCode = $cache->get($key, function (ItemInterface $item) use ($binCode): string {
            $item->expiresAfter(3600);

            $binLookup = static::getLookupData($binCode);

            return $binLookup['country']['alpha2'] ?? '';
        });

        return $countryCode;
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