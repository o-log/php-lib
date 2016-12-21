<?php


namespace OLOG;


class IP
{
    static public function isPrivateNetwork($ip)
    {
        if (preg_match("/unknown/", $ip))
            return true;
        if (preg_match("/127\.0\./", $ip))
            return true;
        if (preg_match("/^192\.168\./", $ip))
            return true;
        if (preg_match("/^10\./", $ip))
            return true;
        if (preg_match("/^172\.16\./", $ip))
            return true;
        if (preg_match("/^172\.17\./", $ip))
            return true;
        if (preg_match("/^172\.18\./", $ip))
            return true;
        if (preg_match("/^172\.19\./", $ip))
            return true;
        if (preg_match("/^172\.20\./", $ip))
            return true;
        if (preg_match("/^172\.21\./", $ip))
            return true;
        if (preg_match("/^172\.22\./", $ip))
            return true;
        if (preg_match("/^172\.23\./", $ip))
            return true;
        if (preg_match("/^172\.24\./", $ip))
            return true;
        if (preg_match("/^172\.25\./", $ip))
            return true;
        if (preg_match("/^172\.26\./", $ip))
            return true;
        if (preg_match("/^172\.27\./", $ip))
            return true;
        if (preg_match("/^172\.28\./", $ip))
            return true;
        if (preg_match("/^172\.29\./", $ip))
            return true;
        if (preg_match("/^172\.30\./", $ip))
            return true;
        if (preg_match("/^172\.31\./", $ip))
            return true;

        return false;
    }

    static public function getClientIpRemoteAddr()
    {
        $remote_addr = array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : '';

        return $remote_addr;
    }

    static public function getClientIpXff()
    {
        $remote_addr = self::getClientIpRemoteAddr();

        if (array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $list = array_map('trim', $list);

            foreach ($list as $ip) {
                if (self::isPrivateNetwork($ip)) {
                    break;
                }
                $remote_addr = $ip;
            }
        }

        return $remote_addr;
    }

    static public function isValidNetOrIp($net_or_ip)
    {
        $is_valid = preg_match('@^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(/([0-9]|[1-2][0-9]|3[0-2]))?$@', $net_or_ip);
        return boolval($is_valid);
    }

    static public function checkIPmatchNetOrIP($checked_ip, $net_or_ip)
    {
        $net_arr = explode('/', $net_or_ip);
        $net = $net_arr[0];
        $mask = !empty($net_arr[1]) ? $net_arr[1] : 32;
        if ((ip2long($checked_ip) & ~((1 << (32 - $mask)) - 1)) == (ip2long($net) >> (32 - $mask)) << (32 - $mask)) {
            return true;
        }

        return false;
    }
}