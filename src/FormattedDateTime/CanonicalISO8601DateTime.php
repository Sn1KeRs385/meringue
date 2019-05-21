<?php

namespace Meringue\FormattedDateTime;

use DateTimeInterface;

class CanonicalISO8601DateTime
{
    private $s;

    public function __construct(DateTimeInterface $s)
    {
        $this->s = $s;
    }

    public function value(): string
    {
        if ((int) $this->s->format('u') != 0) {
            return $this->s->format('Y-m-d\TH:i:s.uP');
        }

        return $this->s->format('c');
    }
}