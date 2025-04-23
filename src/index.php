<?php

declare(strict_types=1);

// Check if a CSV file was passed
require __DIR__ . '/../vendor/autoload.php';

use MyBank\CommissionTask\Domain\Calculators\Factory\CommissionCalculatorFactory;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Factory\TrackerFactory;
use MyBank\CommissionTask\Domain\Trackers\Tracker;
use MyBank\CommissionTask\Domain\Transaction;
use MyBank\CommissionTask\Application\CommissionService;
use MyBank\CommissionTask\Application\FileReaders\CsvReader;

//TODO:: add exception handling and test cases

if ($argc < 2) {
    echo "Error in the command, usage: php index.php <path_to_csv>\n";
    exit(1);
}

$csvFile = $argv[1];

if (!file_exists($csvFile)) {
    echo "Error: File not found: $csvFile\n";
    exit(1);
}

$headers = ["date", "user_id", "user_type", "operation", "amount", "currency"];

$fileReader = new CsvReader($csvFile);
$commissionService = null;
try {
    $tracker = TrackerFactory::create(Tracker::WEEK);

    foreach ($fileReader->readByRow($headers, $csvFile) as $row) {
        $transaction = new Transaction(
            DateTime::createFromFormat("Y-m-d", $row["date"]),
            (int)$row["user_id"],
            $row["user_type"],
            $row["operation"],
            new Money(floatval($row["amount"]), $row["currency"])
        );

        $calculator = CommissionCalculatorFactory::createForTransaction($transaction);
        if (is_null($commissionService)) {
            $commissionService = new CommissionService($calculator, $tracker);
        } else {
            $commissionService->setCalculator($calculator);
        }
        $commission = $commissionService->calculateCommission($transaction);

        echo "$commission\n";
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

