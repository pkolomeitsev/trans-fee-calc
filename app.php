<?php

require_once 'vendor/autoload.php';

use TransFeeCalc\Transaction\Reader;
use TransFeeCalc\Transaction\Validator\Validator;
use TransFeeCalc\Transaction\Facade\Processor as FeeProcessor;

$binFile = $argv[1] ?? 'input.txt';

foreach ((new FeeProcessor(new Reader($binFile, new Validator())))->getResult() as $fee){
    echo $fee . PHP_EOL;
}
