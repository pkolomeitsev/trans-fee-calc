<?php
declare(strict_types=1);

namespace TransFeeCalc\Transaction\Validator;

interface ValidatorInterface
{
    public function validate(array $data): bool;
}