<?php

namespace OLOG;

class URL
{
    static public function path()
    {
        $url = $_SERVER['REQUEST_URI'];
        $no_form = $url;

        if (strpos($url, '?')) {
            list($no_form, $form) = explode('?', $url);
        }

        return $no_form;
    }

    static public function current()
    {
        $url = $_SERVER['REQUEST_URI'];

        return $url;
    }

    static public function build($url_parts_arr)
    {
        $url_parts_arr = array_map(function($var) {
            return trim($var, '/');
        }, $url_parts_arr);

        $url =  implode($url_parts_arr,'/');

        return $url;
    }
}