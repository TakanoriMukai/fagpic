<?php

namespace App\Util;

class TimeMeasurement
{
    private static $start_time;
    private static $measuring = false;

    public static function start()
    {
        TimeMeasurement::$start_time = microtime(true);
        TimeMeasurement::$measuring = true;
    }
    public static function stop()
    {
        $time = microtime(true) - TimeMeasurement::$start_time;
        TimeMeasurement::$measuring = false;
        return $time;
    }

    public static status()
    {
        return TimeMeasurement::$measuring;
    }

}
