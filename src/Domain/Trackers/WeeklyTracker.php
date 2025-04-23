<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Trackers;

use MyBank\CommissionTask\Domain\Money;

class WeeklyTracker extends Tracker
{
    private $history;

    public function __construct()
    {
        parent::__construct(parent::WEEK);
    }

}