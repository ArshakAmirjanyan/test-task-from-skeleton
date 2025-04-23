<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Application\FileReaders;

use Generator;

class ExcelReader implements FileReaderInterface
{
    public function readByRow($headers, $file): Generator {
        //TODO:: implement an excel reader logic
        yield(1);
    }
}