<?php

namespace WebduoNederland\PulseApi\Actions;

class Interval
{
    public array $allowedIntervals = [
        1,
        6,
        24,
        168,
    ];

    public function isValid(mixed $interval): bool
    {
        if (! is_numeric($interval)) {
            return false;
        }

        $interval = intval($interval);

        if (! in_array($interval, $this->allowedIntervals)) {
            return false;
        }

        return true;
    }
}
