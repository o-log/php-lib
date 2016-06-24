<?php

namespace OLOG;

class Exits
{
    static public function exit404()
    {
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    static public function exit429()
    {
        header("HTTP/1.0 429 Too Many Requests");
        exit();
    }

    static public function exit408()
    {
        header("HTTP/1.0 408 Request Timeout");
        exit();
    }

    static public function exit404If($exit_condition)
    {
        if (!$exit_condition) {
            return;
        }

        header("HTTP/1.0 404 Not Found");
        exit();
    }

    static public function exit403If($exit_condition)
    {
        if (!$exit_condition) {
            return;
        }

        header("HTTP/1.0 403 Forbidden");

        exit();
    }

    static public function exit403()
    {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }

    static public function exit400If($exit_condition)
    {
        if (!$exit_condition) {
            return;
        }

        header("HTTP/1.0 400 Bad Request");
        exit();
    }

    static public function exit403IfWithMessage($exit_condition, $message = '')
    {
        if (!$exit_condition) {
            return;
        }

        header("HTTP/1.0 403 Forbidden");
        if ($message != '') {
            echo $message;
        }

        exit();
    }

    public static function exit405($allowed_methods_arr = array())
    {
        header("HTTP/1.1 405 Method Not Allowed");
        if (!empty($allowed_methods_arr)) {
            self::setAllowedMethodsHeaders($allowed_methods_arr);
        }

        exit();
    }

    public static function setAllowedMethodsHeaders($allowed_methods_arr)
    {
        Assert::assert(is_array($allowed_methods_arr));
        self::setAccessControlAllowOriginHeader();

        header('Access-Control-Allow-Methods: ' . implode(', ', $allowed_methods_arr));
        header('Allow: ' . implode(', ', $allowed_methods_arr));
    }

    public static function setAccessControlAllowOriginHeader()
    {
        // TODO: review!
        $allowed_hosts = \OLOG\ConfWrapper::value('access_control_allow_origin_header', '');

        if ($allowed_hosts != '') {
            header('Access-Control-Allow-Origin: ' . $allowed_hosts);
        }
    }
}