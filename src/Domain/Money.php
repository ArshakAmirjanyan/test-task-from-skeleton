<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain;

use MyBank\CommissionTask\Infrastructure\StabExchangeRateProvider;

class Money
{
    const EUR = "EUR";
    const USD = "USD";
    const JPY = "JPY";

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    public function __construct(float $amount, string $currency)
    {
        $this->amount = round($amount, 2);
        $this->currency = $currency;
    }

    /**
     * @param string $targetCurrency
     * @return Money
     * @throws \Exception
     */
    public function convertTo(string $targetCurrency): Money
    {
        $provider = StabExchangeRateProvider::getInstance();
        $rates = $provider->getRates();

        if (!isset($rates[$this->currency]) || !isset($rates[$targetCurrency])) {
            throw new \Exception("Conversion rate missing.");
        }

        $amountInEur = $this->amount / $rates[$this->currency];
        $convertedAmount = $amountInEur * $rates[$targetCurrency];

        return new Money($convertedAmount, $targetCurrency);
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param float $percentage
     * @return Money
     */
    public function percentage(float $percentage): Money
    {
        $amount = $this->amount * $percentage / 100;

        return new Money($amount, $this->currency);
    }

    /**
     * @param $money
     * @return Money
     */
    public function add($money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            $money = $money->convertTo($this->currency);
        }

        $newAmount = $this->amount + $money->getAmount();

        return new Money($newAmount, $this->currency);
    }

    /**
     * @param $money
     * @return Money
     */
    public function subtract($money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            $money->convertTo($this->currency);
        }

        $newAmount = $this->amount - $money->getAmount();

        return new Money($newAmount, $this->currency);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "$this->amount " . "$this->currency";
    }
}