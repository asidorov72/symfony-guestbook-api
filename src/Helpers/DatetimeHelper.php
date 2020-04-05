<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4.4.2020 г.
 * Time: 12:59
 */

namespace App\Helpers;

use \DateTime;
use \DateTimeZone;

class DatetimeHelper
{
    private const LOCAL_TIMEZONE = 'Europe/Sofia';

    public static function getCurrentDatetime()
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone(self::LOCAL_TIMEZONE));

        return $now->format('Y-m-d H:i:s');
    }
}
