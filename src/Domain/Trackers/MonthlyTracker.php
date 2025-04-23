<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Trackers;

use MyBank\CommissionTask\Domain\Money;

class MonthlyTracker extends Tracker
{
    /**
     * @var array
     */
    private $history = [];

    public function __construct()
    {
        parent::__construct(parent::MONTH);
    }

}