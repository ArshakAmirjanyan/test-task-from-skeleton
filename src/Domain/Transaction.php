<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain;

use DateTime;

class Transaction
{
    /**
     * @var DateTime
     */
    private $date;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var string
     */
    private $userType;
    /**
     * @var string
     */
    private $operation;
    /**
     * @var Money
     */
    private $money;

    /**
     * @param DateTime $date
     * @param int $userId
     * @param string $userType
     * @param string $operation
     * @param Money $money
     */
    public function __construct(DateTime $date, int $userId, string $userType, string $operation, Money $money)
    {
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->operation = $operation;
        $this->money = $money;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserType(): string
    {
        return $this->userType;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->money->getAmount();
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->money->getCurrency();
    }


}