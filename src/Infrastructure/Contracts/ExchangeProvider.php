<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Infrastructure\Contracts;

interface ExchangeProvider
{
    public function getRates(): array;
    public function getRateFor(string $currency): float;
}