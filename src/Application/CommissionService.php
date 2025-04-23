<?php
declare(strict_types=1);

namespace MyBank\CommissionTask\Application;

use MyBank\CommissionTask\Domain\Calculators\Contracts\CommissionCalculator;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

class CommissionService
{

    /**
     * @var CommissionCalculator
     */
    private $calculator;
    /**
     * @var TrackerInterface
     */
    private $tracker;

    /**
     * @param CommissionCalculator $calculator
     * @param TrackerInterface $tracker
     */
    public function __construct(CommissionCalculator $calculator, TrackerInterface $tracker)
    {
        $this->calculator = $calculator;
        $this->tracker = $tracker;
    }

    /**
     * @param CommissionCalculator $calculator
     * @return void
     */
    public function setCalculator(CommissionCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @param Transaction $transaction
     * @return Money
     */
    public function calculateCommission(Transaction $transaction): Money
    {
        $commission = $this->calculator->calculateCommission($transaction, $this->tracker);

        return $commission;
    }
}