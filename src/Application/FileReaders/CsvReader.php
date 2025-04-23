<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Application\FileReaders;

use Generator;

class CsvReader implements FileReaderInterface
{
    public function readByRow($headers, $file): Generator
    {
        if (($handle = fopen($file, 'r')) !== false) {

            while (($data = fgetcsv($handle)) !== false) {
                yield array_combine($headers, $data);
            }

            fclose($handle);
        }
    }
}
