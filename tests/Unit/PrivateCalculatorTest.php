<?php

namespace MyBank\CommissionTask\Tests\Unit;


use DateTime;
use MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Withdraw\PrivateCalculator;
use MyBank\CommissionTask\Domain\Money;
use PHPUnit\Framework\TestCase;
use MyBank\CommissionTask\Domain\Transaction;
use MyBank\CommissionTask\Domain\Trackers\WeeklyTracker;

final class PrivateCalculatorTest extends TestCase
{
    public function testCommissionIsZeroWhenUnderLimit(): void
    {
        $calculator = new PrivateCalculator();
        $tracker = new WeeklyTracker();

        $tx = new Transaction(
            DateTime::createFromFormat("Y-m-d", '2014-12-31'),
            4,
            'private',
            'withdraw',
            new Money(300, 'EUR')
        );
        $result = $calculator->calculateCommission($tx, $tracker);

        $this->assertEquals(0, $result->getAmount());
    }

    public function testCommissionAppliesCorrectlyAboveLimit(): void
    {
        $calculator = new PrivateCalculator();
        $tracker = new WeeklyTracker();

        $tracker->addToHistory(
            new Transaction(
                DateTime::createFromFormat("Y-m-d", '2014-12-31'),
                4,
                'private',
                'withdraw',
                new Money(1000, 'EUR')
            )
        );
        $tx = new Transaction(DateTime::createFromFormat("Y-m-d", '2014-12-31'), 4, 'private', 'withdraw', new Money('100', 'EUR'));

        $result = $calculator->calculateCommission($tx, $tracker);

        $this->assertEquals(0.5, $result->getAmount());
    }
}