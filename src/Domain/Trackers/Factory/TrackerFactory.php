<?php declare(strict_types=1);

namespace MyBank\CommissionTask\Domain\Trackers\Factory;

use MyBank\CommissionTask\Domain\Trackers\MonthlyTracker;
use MyBank\CommissionTask\Domain\Trackers\Tracker;
use MyBank\CommissionTask\Domain\Trackers\WeeklyTracker;

class TrackerFactory
{

    /**
     * @param string $period
     * @return Tracker
     * @throws \Exception
     */
    public static function create(string $period): Tracker
    {
        switch ($period) {
            case Tracker::WEEK:
                return new WeeklyTracker();
                break;
            case Tracker::MONTH:
                return new MonthlyTracker();
                break;
            default:
                throw new \Exception("Invalid period");
        }
    }

}