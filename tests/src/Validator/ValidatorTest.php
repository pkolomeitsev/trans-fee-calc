<?php

namespace Tests\Validator;

use PHPUnit\Framework\TestCase;
use TransFeeCalc\Transaction\Validator\Validator;

class ValidatorTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    /**
     * @dataProvider dataProvider
     *
     * @param array $data
     * @param bool $expected
     * @return void
     */
    public function testValidate(array $data, bool $expected)
    {
        $this->assertEquals($expected, $this->validator->validate($data));
    }

    /**
     * @return array[]
     */
    public static function dataProvider(): array
    {
        return [
            [
                'data' => ['bin' => '1234', 'amount' => 100, 'currency' => 'EUR'],
                'expected' => true
            ],
            [
                'data' => ['bin' => '1234', 'amount' => 100],
                'expected' => false
            ],
            [
                'data' => ['bin' => '1234'],
                'expected' => false
            ],
            [
                'data' => ['some other stuff' => 'has value'],
                'expected' => false
            ],
        ];
    }
}