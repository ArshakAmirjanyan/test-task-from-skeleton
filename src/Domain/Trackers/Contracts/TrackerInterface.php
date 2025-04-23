<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Trackers\Contracts;

use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Transaction;

interface TrackerInterface
{
    public function addToHistory(Transaction $transaction);

    public function getTransactionNoForThePeriod(Transaction $transaction): int;

    public function getCumulativeAmountForThePeriod(Transaction $transaction, string $currency): Money;
}