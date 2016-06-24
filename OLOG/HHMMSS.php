<?php

namespace OLOG;


class HHMMSS
{
    public static function hhmmss2seconds($hhmmss_str)
    {
        list($hours, $mins, $secs) = explode(':', $hhmmss_str);
        $secs = round($secs);
        return ($hours * 3600) + ($mins * 60) + $secs;
    }
}