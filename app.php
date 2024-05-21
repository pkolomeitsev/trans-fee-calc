<?php

require_once 'vendor/autoload.php';

use TransFeeCalc\Transaction\Aggregator;
use TransFeeCalc\Transaction\Reader;
use TransFeeCalc\Fee\Calculator as FeeCalculator;

$binFile = $argv[1] ?? 'input.txt';

$data = (new Reader($binFile))
    ->readData()
    ->getData();

$collection = (new Aggregator($data))
    ->aggregate()
    ->getCollection();

echo (new FeeCalculator($collection))->calculate() . PHP_EOL;