<?php

namespace OLOG;


class HHMMSS
{
    public static function hhmmss2seconds($time)
    {
        list($hours, $mins, $secs) = explode(':', $time);
        $secs = round($secs);
        return ($hours * 3600) + ($mins * 60) + $secs;
    }
}