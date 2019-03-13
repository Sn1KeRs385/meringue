<?php

declare(strict_types=1);

namespace Meringue\Tests\ScheduleTest;

use Meringue\ISO8601DateTime;
use Meringue\ISO8601DateTime\FromMilliseconds;
use Meringue\ISO8601DateTime\FromISO8601;
use Meringue\ISO8601Interval;
use Meringue\ISO8601Interval\FromRange;
use Meringue\Schedule\ByWeekDays;
use Meringue\Schedule\Daily;
use Meringue\Schedule\TwentyFourSeven;
use Meringue\Time;
use Meringue\Time\DefaultTime;
use PHPUnit\Framework\TestCase;

class ByWeekDaysTest extends TestCase
{
    /**
     * @dataProvider hitDateTimes
     */
    public function testIsHit(ISO8601DateTime $dateTime)
    {
        $this->assertTrue(
            (new ByWeekDays(
                new Daily(
                    new DefaultTime(11, 0, 0),
                    new DefaultTime(12, 30, 0)
                ),
                new Daily(
                    new DefaultTime(12, 31, 0),
                    new DefaultTime(13, 47, 0)
                ),
                new Daily(
                    new DefaultTime(14, 8, 0),
                    new DefaultTime(15, 17, 0)
                ),
                new Daily(
                    new DefaultTime(15, 18, 0),
                    new DefaultTime(15, 59, 0)
                ),
                new Daily(
                    new DefaultTime(16, 0, 0),
                    new DefaultTime(17, 30, 0)
                ),
                new Daily(
                    new DefaultTime(17, 31, 0),
                    new DefaultTime(18, 30, 0)
                ),
                new Daily(
                    new DefaultTime(18, 31, 0),
                    new DefaultTime(23, 42, 0)
                )
            ))
                ->isHit($dateTime)
        );
    }

    public function hitDateTimes()
    {
        return [
            [new FromISO8601('2019-03-31 11:11:00')],
            [new FromISO8601('2019-04-01 12:49:54')],
            [new FromISO8601('2019-04-02 14:08:00')],
            [new FromISO8601('2019-04-03 15:59:00')],
            [new FromISO8601('2019-04-04 16:27:00')],
            [new FromISO8601('2019-04-05 18:00:00')],
            [new FromISO8601('2019-04-06 23:00:01')],
        ];
    }

    /**
     * @dataProvider missingDateTimes
     */
    public function testIsMissing(ISO8601DateTime $dateTime)
    {
        $this->assertFalse(
            (new ByWeekDays(
                new Daily(
                    new DefaultTime(11, 0, 0),
                    new DefaultTime(12, 30, 0)
                ),
                new Daily(
                    new DefaultTime(12, 31, 0),
                    new DefaultTime(13, 47, 0)
                ),
                new Daily(
                    new DefaultTime(14, 8, 0),
                    new DefaultTime(15, 17, 0)
                ),
                new Daily(
                    new DefaultTime(15, 18, 0),
                    new DefaultTime(15, 59, 0)
                ),
                new Daily(
                    new DefaultTime(16, 0, 0),
                    new DefaultTime(17, 30, 0)
                ),
                new Daily(
                    new DefaultTime(17, 31, 0),
                    new DefaultTime(18, 30, 0)
                ),
                new Daily(
                    new DefaultTime(18, 31, 0),
                    new DefaultTime(23, 42, 0)
                )
            ))
                ->isHit($dateTime)
        );
    }

    public function missingDateTimes()
    {
        return [
            [new FromISO8601('2019-03-31 10:59:59')],
            [new FromISO8601('2019-03-31 12:30:01')],
            [new FromISO8601('2019-03-31 23:02:25')],

            [new FromISO8601('2019-04-01 12:29:54')],
            [new FromISO8601('2019-04-01 13:47:01')],
            [new FromISO8601('2019-04-01 22:10:00')],

            [new FromISO8601('2019-04-02 14:07:59')],
            [new FromISO8601('2019-04-02 15:17:01')],
            [new FromISO8601('2019-04-02 21:00:00')],

            [new FromISO8601('2019-04-03 15:17:00')],
            [new FromISO8601('2019-04-03 16:00:00')],

            [new FromISO8601('2019-04-04 15:27:00')],
            [new FromISO8601('2019-04-04 17:31:00')],

            [new FromISO8601('2019-04-05 17:30:00')],
            [new FromISO8601('2019-04-05 18:30:01')],

            [new FromISO8601('2019-04-06 18:00:01')],
            [new FromISO8601('2019-04-06 23:57:01')],
        ];
    }
}