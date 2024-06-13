<?php

namespace TransFeeCalc\Transaction\Validator;

class Validator implements ValidatorInterface
{
    private array $filterKeys = [
        'bin', 'amount', 'currency'
    ];

    public function validate(array $data): bool
    {
        return empty(array_diff($this->filterKeys, array_keys($data)));
    }
}