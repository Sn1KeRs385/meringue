<?php

declare(strict_types=1);

namespace Meringue\Schedule;

use DateTimeImmutable as PHPDateTime;
use Exception;
use Meringue\Date\FromISO8601DateTime;
use Meringue\FormattedDateTime\ISO8601Formatted;
use Meringue\ISO8601DateTime;
use Meringue\ISO8601DateTime\FromISO8601;
use Meringue\Time;

class TimePeriod
{
    private $from;
    private $till;

    public function __construct(Time $from, Time $till)
    {
        $this->from = $from;
        $this->till = $till;

        if ($this->from->greaterThan($this->till)) {
            throw new Exception('"Till" must be greater than "from". Use a separate schedule object for the next day\'s schedule if you need to. See ByWeekDaysTest for details.');
        }
    }

    public function fromTillPair()
    {
        return [$this->from, $this->till];
    }

    public function isHit(ISO8601DateTime $dateTime): bool
    {
        return $this->dateTimeIsGreaterOrEqualsToFrom($dateTime) && $this->dateTimeIsLessOrEqualsToTill($dateTime);
    }

    private function dateTimeIsGreaterOrEqualsToFrom(ISO8601DateTime $dateTime)
    {
        return
            new PHPDateTime($dateTime->value())
            >=
            new PHPDateTime(
                (new FromISO8601(
                    (new FromISO8601DateTime($dateTime))->value() . ' ' . $this->from->value() . (new ISO8601Formatted($dateTime, 'P'))->value()
                ))
                    ->value()
            );
    }

    private function dateTimeIsLessOrEqualsToTill(ISO8601DateTime $dateTime)
    {
        return
            new PHPDateTime(
                (new ISO8601Formatted(
                    $dateTime,
                    "c"
                ))
                    ->value()
            )
            <=
            new PHPDateTime(
                (new FromISO8601(
                    (new FromISO8601DateTime($dateTime))->value() . ' ' . $this->till->value() . (new ISO8601Formatted($dateTime, 'P'))->value()
                ))
                    ->value()
            );
    }
}
