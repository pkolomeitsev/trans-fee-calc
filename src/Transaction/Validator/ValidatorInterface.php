<?php

namespace TransFeeCalc\Transaction\Validator;

interface ValidatorInterface
{
    public function validate(array $data): bool;
}