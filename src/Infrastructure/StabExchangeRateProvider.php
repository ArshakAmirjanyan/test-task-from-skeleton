<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Infrastructure;

use MyBank\CommissionTask\Infrastructure\Contracts\ExchangeProvider;

class StabExchangeRateProvider implements ExchangeProvider
{
    private static $instance = null;
    /**
     * @var array
     */
    private $rates = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    private function fetchRates()
    {
        // mock an API call here
        $this->rates = [
            'EUR' => 1.0,
            'USD' => 1.1,
            'JPY' => 129.53,
            //add others if needed
        ];
    }

    /**
     * @return array
     */
    public function getRates(): array
    {
        if (empty($this->rates)) {
            $this->fetchRates();
        }

        return $this->rates;
    }

    /**
     * @param string $currency
     * @return float
     * @throws \Exception
     */
    public function getRateFor(string $currency): float
    {
        $this->getRates();
        if (!isset($this->rates[$currency])) {
            throw new \Exception("Currency rate not found: {$currency}");
        }

        return $this->rates[$currency];
    }

}