<?php

namespace TransFeeCalc\Transaction;

use TransFeeCalc\Transaction\DTO\Transaction;

class Aggregator
{
    /**
     * Transaction DTO collection
     * @var array
     */
    private array $collection;
    private array $filterKeys = [
        'bin', 'amount', 'currency'
    ];

    /**
     * @param array $transactionData
     */
    public function __construct(
        private readonly array $transactionData
    )
    {
    }

    /**
     * @return $this
     */
    public function aggregate(): static
    {
        foreach ($this->transactionData as $row) {
            if (empty(array_diff($this->filterKeys, array_keys($row)))) {
                $this->collection[] = new Transaction($row['bin'], $row['amount'], $row['currency']);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}