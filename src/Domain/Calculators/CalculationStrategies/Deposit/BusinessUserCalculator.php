<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Deposit;

use MyBank\CommissionTask\Domain\Calculators\Contracts\CalculationStrategyByUserType;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

class BusinessUserCalculator implements CalculationStrategyByUserType
{
    /**
     * @var float
     */
    private $commissionPercentage = 0.3;

    /**
     * @param Transaction $transaction
     * @param TrackerInterface $tracker
     * @return Money
     */
    public function calculateCommission(Transaction $transaction, TrackerInterface $tracker): Money
    {
        $commission = $transaction->getMoney()->percentage($this->commissionPercentage);

        return $commission;
    }
}