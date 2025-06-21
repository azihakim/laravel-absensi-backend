<?php

namespace App\Helpers;

class DateHelper
{
    public static function getDatesFromRange($startDate, $endDate)
    {
        $dates = [];
        $currentDate = strtotime($startDate);
        $endDateTimestamp = strtotime($endDate);

        while ($currentDate <= $endDateTimestamp) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }
}
