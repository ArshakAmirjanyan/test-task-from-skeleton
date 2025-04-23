<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Calculators\Factory;

use MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Deposit\BusinessUserCalculator;
use MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Deposit\PrivateUserCalculator;
use MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Withdraw\BusinessCalculator;
use MyBank\CommissionTask\Domain\Calculators\CalculationStrategies\Withdraw\PrivateCalculator;
use MyBank\CommissionTask\Domain\Calculators\Contracts\CommissionCalculator;
use MyBank\CommissionTask\Domain\Calculators\DepositCalculator;
use MyBank\CommissionTask\Domain\Calculators\WithdrawCalculator;

class CommissionCalculatorFactory
{
    /**
     * @param $transaction
     * @return CommissionCalculator
     * @throws \Exception
     */
    public static function createForTransaction($transaction): CommissionCalculator
    {
        if ($transaction->getOperation() === 'withdraw') {
            if ($transaction->getUserType() === 'private') {
                return new WithdrawCalculator(new PrivateCalculator());
            } elseif ($transaction->getUserType() === 'business') {
                return new WithdrawCalculator(new BusinessCalculator());
            }
        }

        if ($transaction->getOperation() === 'deposit') {
            if ($transaction->getUserType() === 'private') {
                return new DepositCalculator(new PrivateUserCalculator());
            } elseif ($transaction->getUserType() === 'business') {
                return new DepositCalculator(new BusinessUserCalculator());
            }
        }

        throw new \Exception('Unknown combination');
    }
}