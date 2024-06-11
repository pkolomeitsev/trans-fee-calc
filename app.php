<?php

require_once 'vendor/autoload.php';

use TransFeeCalc\Transaction\Reader;
use TransFeeCalc\Transaction\Facade\Processor as FeeProcessor;

$binFile = $argv[1] ?? 'input.txt';

foreach ((new FeeProcessor(new Reader($binFile)))->getResult() as $fee){
    echo $fee . PHP_EOL;
}
