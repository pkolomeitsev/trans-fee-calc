<?php

namespace TransFeeCalc\Transaction;

class Reader
{
    const LINE_SIZE = 4096;
    private $filePointer;

    private array $filterKeys = [
        'bin', 'amount', 'currency'
    ];

    /**
     * @param string $file
     * @throws \Exception
     */
    public function __construct(string $file = '')
    {
        if (empty($file)) {
            throw new \Exception('Input file with transactions is no set!');
        }

        if (!file_exists($file)) {
            throw new \Exception(sprintf('%s file doesn\'t exists!', $file));
        }

        $this->filePointer = fopen($file, 'r');
        if (!$this->filePointer) {
            throw new \Exception(sprintf('Can\'t read file %s ', $file));
        }
    }

    /**
     * @return \Generator
     */
    public function getFileData(): \Generator
    {

        while (($line = fgets($this->filePointer, self::LINE_SIZE)) !== false) {

            $data = json_decode($line, true);

            if (!empty(array_diff($this->filterKeys, array_keys($data)))) {
                echo sprintf('Data is not consistent: %s', $line);
                continue;
            }

            yield $data;
        }
    }

    public function __destruct()
    {
        fclose($this->filePointer);
    }
}