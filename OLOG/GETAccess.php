<?php

namespace OLOG;

class GETAccess
{
    static public function getRequiredGetValue($key)
    {
        $value = '';

        if (array_key_exists($key, $_GET)) {
            $value = $_GET[$key];
        }

        \OLOG\Assert::assert($value != '', 'Missing required GET field ' . $key); // TODO: library used while not mentioned in config

        return $value;
    }

    static public function getOptionalGetValue($key, $default = '')
    {
        $value = '';

        if (array_key_exists($key, $_GET)) {
            $value = $_GET[$key];
        }

        if ($value == '') {
            $value = $default;
        }

        return $value;
    }

}