<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators\Contracts;

use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

interface CalculationStrategyByUserType
{
    /**
     * @param Transaction $transaction
     * @param TrackerInterface $tracker
     * @return Money
     */
    public function calculateCommission(Transaction $transaction, TrackerInterface $tracker): Money;

}