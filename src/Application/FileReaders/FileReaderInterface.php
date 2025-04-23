<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Application\FileReaders;

interface FileReaderInterface
{
    public function readByRow($headers, $file);
}