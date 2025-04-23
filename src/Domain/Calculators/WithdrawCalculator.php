<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators;


use MyBank\CommissionTask\Domain\Calculators\Contracts\CalculationStrategyByUserType;
use MyBank\CommissionTask\Domain\Calculators\Contracts\CommissionCalculator;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

class WithdrawCalculator implements CommissionCalculator
{
    /**
     * @var CalculationStrategyByUserType
     */
    private $userCalculator;

    /**
     * @param CalculationStrategyByUserType $userCalculator
     */
    public function __construct(CalculationStrategyByUserType $userCalculator)
    {
        $this->userCalculator = $userCalculator;
    }

    /**
     * @param Transaction $transaction
     * @param TrackerInterface $tracker
     * @return Money
     */
    public function calculateCommission(Transaction $transaction, TrackerInterface $tracker): Money
    {
        $commission = $this->userCalculator->calculateCommission($transaction, $tracker);

        return $commission;
    }

}