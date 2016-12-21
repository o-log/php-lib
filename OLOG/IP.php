<?php


namespace OLOG;


class IP
{
    /**
     * https://tools.ietf.org/html/rfc6890#section-2.2.2
     * Следующие диапазоны определены IANA как адреса, выделенные локальным сетям:
     * - 10.0.0.0 — 10.255.255.255 (маска подсети для бесклассовой (CIDR) адресации: 255.0.0.0 или /8)
     * - 172.16.0.0 — 172.31.255.255 (маска подсети для бесклассовой (CIDR) адресации: 255.240.0.0 или /12)
     * - 192.168.0.0 — 192.168.255.255 (маска подсети для бесклассовой (CIDR) адресации: 255.255.0.0 или /16)
     * Также для петлевых интерфейсов (не используется для обмена между узлами сети) зарезервирован диапазон 127.0.0.0 — 127.255.255.255 (маска подсети для бесклассовой (CIDR) адресации: 255.0.0.0 или /8)
     *
     * @param $ip
     * @return bool
     */
    static public function ipIsInPrivateNetwork($ip)
    {
        $private_network_classes_arr = ['10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16', '127.0.0.0/8'];
        foreach ($private_network_classes_arr as $network) {
            if (self::checkIPmatchNetOrIP($ip, $network)) {
                return true;
            }
        }

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
                if (preg_match("/unknown/", $ip)) {
                    return true;
                }

                if (self::ipIsInPrivateNetwork($ip)) {
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