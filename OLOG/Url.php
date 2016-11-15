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

    static public function buildUrl($url_parts_arr)
    {
        $url_parts_arr = array_map(function($var) {
            return trim($var, '/');
        }, $url_parts_arr);

        $url =  implode($url_parts_arr,'/');

        return $url;
    }
}