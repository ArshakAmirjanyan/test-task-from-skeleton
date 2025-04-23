<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Withdraw;

use MyBank\CommissionTask\Domain\Calculators\Contracts\CalculationStrategyByUserType;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

class BusinessCalculator implements CalculationStrategyByUserType
{
    /**
     * @var float
     */
    private $commissionPercentage = 0.5;

    /**
     * @param Transaction $transaction
     * @param TrackerInterface $tracker
     * @return mixed
     */
    public function calculateCommission(Transaction $transaction, TrackerInterface $tracker): Money
    {
        $commissionAmount = $transaction->getMoney()->percentage($this->commissionPercentage);

        return $commissionAmount;
    }
}