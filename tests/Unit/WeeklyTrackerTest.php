<?php

namespace MyBank\CommissionTask\Tests\Unit;

use DateTime;
use MyBank\CommissionTask\Domain\Money;
use PHPUnit\Framework\TestCase;
use MyBank\CommissionTask\Domain\Trackers\WeeklyTracker;
use MyBank\CommissionTask\Domain\Transaction;

final class WeeklyTrackerTest extends TestCase
{
    public function testTransactionCounting(): void
    {
        $tracker = new WeeklyTracker();
        $tx1 = new Transaction(
            DateTime::createFromFormat("Y-m-d", '2014-12-31'),
            4,
            'private',
            'withdraw',
            new Money(200, "EUR")
        );

        $tracker->addToHistory($tx1);

        $this->assertEquals(1, $tracker->getTransactionNoForThePeriod($tx1));
    }

    public function testCumulativeAmountCalculation(): void
    {
        $tracker = new WeeklyTracker();

        $tx1 = new Transaction(
            DateTime::createFromFormat("Y-m-d", '2014-12-31'),
            4,
            'private',
            'withdraw',
            new Money(200, 'EUR')
        );
        $tx2 = new Transaction(
            DateTime::createFromFormat("Y-m-d", '2014-12-31'),
            4,
            'private',
            'withdraw',
            new Money(300, 'EUR')
        );

        $tracker->addToHistory($tx1);
        $tracker->addToHistory($tx2);

        $this->assertEquals(500, $tracker->getCumulativeAmountForThePeriod($tx2, "EUR")->getAmount());
    }
}
