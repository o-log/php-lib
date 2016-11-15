<?php

namespace OLOG;

class Url
{
    static public function getCurrentUrlNoGetForm()
    {
        $url = $_SERVER['REQUEST_URI'];
        $no_form = $url;

        if (strpos($url, '?')) {
            list($no_form, $form) = explode('?', $url);
        }

        return $no_form;
    }

    static public function getCurrentUrl()
    {
        $url = $_SERVER['REQUEST_URI'];

        return $url;
    }

    static public function buildUrl()
    {
        $func_args_arr = func_get_args();
        $func_args_arr = array_map(function($var) {
            return trim($var, '/');
        }, $func_args_arr);

        $url =  implode($func_args_arr,'/');

        return $url;
    }
}