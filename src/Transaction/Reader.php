<?php

namespace TransFeeCalc\Transaction;

class Reader
{
    private array $data = [];

    /**
     * @param string $file
     * @throws \Exception
     */
    public function __construct(
        private readonly string $file = ''
    )
    {
        if (empty($this->file)) {
            throw new \Exception('Input file with transactions is no set!');
        }

        if (file_exists($this->file)) {
            throw new \Exception(sprintf('%s file doesn\'t exists!', $this->file));
        }
    }

    /**
     * @return array
     */
    public function getFileData():array
    {
        $fileData = file_get_contents($this->file);
        if (empty($fileData)) {
            return [];
        }

        return explode("\n", $fileData);
    }

    /**
     * @return $this
     */
    public function readData(): static
    {
        $fileData = $this->getFileData();

        foreach ($fileData as $jsonString) {
            $this->data[] = json_decode($jsonString, true);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}