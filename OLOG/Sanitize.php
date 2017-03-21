<?php

namespace OLOG;

class Sanitize
{
    static public function sanitizeTagContent($value)
    {
        $value = htmlspecialchars($value);
        //$value = preg_replace('@\R@mu', '<br>', $value); // использовать white-space: pre-wrap для вывода строк с переносами внутри
        return $value;
    }

    static public function sanitizeUrl($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    static public function sanitizeAttrValue($value)
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5);
    }

    static public function sanitizeSqlColumnName($column_name){
        $column_name = preg_replace("/[^a-zA-Z0-9_]+/", "", $column_name);
        return $column_name;
    }
}
