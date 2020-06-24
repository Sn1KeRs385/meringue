<?php

declare(strict_types=1);

namespace Meringue\Date\Week;

use Meringue\Date\Week;
use Meringue\ISO8601DateTime;

class FromISO8601DateTime extends Week
{
    private $dateTime;

    public function __construct(ISO8601DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function value(): ISO8601DateTime
    {

    }
}