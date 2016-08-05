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

    public static function seconds2hhmmss($seconds)
    {
        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $H, $i, $s);
    }
}