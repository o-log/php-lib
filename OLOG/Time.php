<?php

namespace OLOG;


class Time
{
    public static function time2seconds($time)
    {
        list($hours, $mins, $secs) = explode(':', $time);
        $secs = round($secs);
        return ($hours * 3600) + ($mins * 60) + $secs;
    }
}