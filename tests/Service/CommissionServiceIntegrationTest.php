<?php

namespace MyBank\CommissionTask\Tests\Service;


use DateTime;
use MyBank\CommissionTask\Domain\Calculators\Factory\CommissionCalculatorFactory;
use MyBank\CommissionTask\Domain\Money;
use PHPUnit\Framework\TestCase;
use MyBank\CommissionTask\Application\CommissionService;
use MyBank\CommissionTask\Domain\Transaction;
use MyBank\CommissionTask\Domain\Trackers\WeeklyTracker;
use MyBank\CommissionTask\Domain\Calculators\WithdrawCalculator;

final class CommissionServiceIntegrationTest extends TestCase
{
    public function testServiceCalculatesCommissionCorrectly(): void
    {
        $tx = new Transaction(
            DateTime::createFromFormat("Y-m-d", '2014-12-31'),
            4,
            'private',
            'withdraw',
            new Money(1200, 'EUR')
        );

        $tracker = new WeeklyTracker();

        $calculator = CommissionCalculatorFactory::createForTransaction($tx);
        $service = new CommissionService($calculator, $tracker);

        $commission = $service->calculateCommission($tx);

        $this->assertEquals(1.0, $commission->getAmount());
    }
}