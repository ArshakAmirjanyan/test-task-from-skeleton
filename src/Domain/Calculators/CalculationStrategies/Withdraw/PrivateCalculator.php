<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Withdraw;

use MyBank\CommissionTask\Domain\Calculators\Contracts\CalculationStrategyByUserType;
use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

class PrivateCalculator implements CalculationStrategyByUserType
{
    /**
     * @var int
     */
    private $freeAmountLimit = 1000;

    /**
     * @var string
     */
    private $currency = Money::EUR;

    /**
     * @var int
     */
    private $freeCount = 3;

    /**
     * @var float
     */
    private $commissionPercentage = 0.5;

    /**
     * @param Transaction $transaction
     * @param TrackerInterface $tracker
     * @return Money
     * @throws \Exception
     */
    public function calculateCommission(Transaction $transaction, TrackerInterface $tracker): Money
    {
        $commissionFreeLimit = new Money($this->freeAmountLimit, $this->currency);
        $currentAmountForThePeriod = $tracker->getCumulativeAmountForThePeriod($transaction, $this->currency);
        $tracker->addToHistory($transaction);
        $transactionNum = $tracker->getTransactionNoForThePeriod($transaction);

        if ($transactionNum < $this->freeCount) {
            if ($currentAmountForThePeriod->subtract($commissionFreeLimit)->getAmount() <= 0) {
                $newAmount = $currentAmountForThePeriod->add($transaction->getMoney());
                if ($commissionFreeLimit->subtract($newAmount)->getAmount() > 0) {
                    return new Money(0, $transaction->getCurrency());
                }

                return $commission = $newAmount->subtract($commissionFreeLimit)->convertTo(
                    $transaction->getCurrency()
                )->percentage($this->commissionPercentage);
            }
        }

        $commission = $transaction->getMoney()->percentage($this->commissionPercentage);

        return $commission;
    }
}