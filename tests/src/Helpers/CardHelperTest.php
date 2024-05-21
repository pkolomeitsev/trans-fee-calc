<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Helpers\CardHelper;

class CardHelperTest extends TestCase
{
    public function testIsEuAssociated()
    {
        $this->assertTrue(CardHelper::isEuAssociated('DE'));
        $this->assertFalse(CardHelper::isEuAssociated('US'));
    }

    public function testGetCountryCodeByBin()
    {
        $this->assertEquals('DE', CardHelperMock::getCountryCodeByBin('12345'));
    }
}

class CardHelperMock extends CardHelper
{
    public static function getLookupData(string $binCode): array
    {
        return [
            'country' => [
                'alpha2' => 'DE'
            ]
        ];
    }
}