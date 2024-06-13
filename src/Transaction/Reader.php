<?php

namespace TransFeeCalc\Transaction;

use TransFeeCalc\Transaction\Validator\ValidatorInterface;

class Reader
{
    const LINE_SIZE = 4096;
    private $filePointer;
    private ValidatorInterface $validator;

    /**
     * @param string $file
     * @param ValidatorInterface $validator
     * @throws \Exception
     */
    public function __construct(string $file, ValidatorInterface $validator)
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

        $this->validator = $validator;
    }

    /**
     * @return \Generator
     */
    public function getFileData(): \Generator
    {
        // PHP is not properly recognizing the line endings
        // when reading files either on or created by a Macintosh computer
        // set the auto_detect_line_endings run-time configuration option to solve the issue
        ini_set("auto_detect_line_endings", true);

        while (($line = fgets($this->filePointer, self::LINE_SIZE)) !== false) {

            $data = json_decode($line, true);

            if (empty($data) || !is_array($data) || !$this->validator->validate($data)) {
                echo sprintf('Data is not consistent: %s', $line);
                continue;
            }

            yield $data;
        }
    }

    public function __destruct()
    {
        if (!empty($this->filePointer)) {
            fclose($this->filePointer);
        }
    }
}