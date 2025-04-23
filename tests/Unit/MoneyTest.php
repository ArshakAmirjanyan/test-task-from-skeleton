<?php

namespace MyBank\CommissionTask\Tests\Unit;

use PHPUnit\Framework\TestCase;
use MyBank\CommissionTask\Domain\Money;

final class MoneyTest extends TestCase
{
    public function testConversionToSameCurrency(): void
    {
        $money = new Money(100, 'EUR');
        $converted = $money->convertTo('EUR');

        $this->assertEquals(100, $converted->getAmount());
        $this->assertEquals('EUR', $converted->getCurrency());
    }

    public function testConversionToAnotherCurrency(): void
    {
        $money = new Money(110, 'USD'); // assuming 1 USD = 1.1 EUR
        $converted = $money->convertTo('EUR');

        $this->assertEquals(100, round($converted->getAmount(), 2));
        $this->assertEquals('EUR', $converted->getCurrency());
    }
}