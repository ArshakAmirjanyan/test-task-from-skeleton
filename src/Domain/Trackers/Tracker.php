<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Trackers;

use MyBank\CommissionTask\Domain\Money;
use MyBank\CommissionTask\Domain\Trackers\Contracts\TrackerInterface;
use MyBank\CommissionTask\Domain\Transaction;

abstract class Tracker implements TrackerInterface
{
    /**
     * @var array
     */
    private $history = [];
    const WEEK = "W";
    const MONTH = "M";
    const YEAR = "Y";

    /**
     * @var string
     */
    private $periodAnnotation;

    public function __construct($periodAnnotation)
    {
        $this->periodAnnotation = $periodAnnotation;
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function addToHistory(Transaction $transaction)
    {
        $weekNum = intval($transaction->getDate()->format($this->periodAnnotation));
        $userId = $transaction->getUserId();

        $this->history[$userId][$weekNum][] = new Money($transaction->getAmount(), $transaction->getCurrency());
    }

    /**
     * @param Transaction $transaction
     * @return int
     */
    public function getTransactionNoForThePeriod(Transaction $transaction): int
    {
        $weekNum = intval($transaction->getDate()->format($this->periodAnnotation));
        $userId = $transaction->getUserId();
        $transactionNum = count($this->history[$userId][$weekNum]);

        return $transactionNum;
    }

    public function getCumulativeAmountForThePeriod(Transaction $transaction, string $currency): Money
    {
        $weekNum = intval($transaction->getDate()->format($this->periodAnnotation));
        $userId = $transaction->getUserId();
        $totalAmount = new Money(0, $currency);

        if (isset($this->history[$userId][$weekNum])) {
            foreach ($this->history[$userId][$weekNum] as $transactionRecord) {
                $totalAmount = $totalAmount->add($transactionRecord);
            }
        }

        return $totalAmount;
    }

}