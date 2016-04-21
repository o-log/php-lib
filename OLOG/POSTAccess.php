<?php

namespace OLOG;

class POSTAccess
{
    static public function getRequiredPostValue($key)
    {
        $value = '';

        if (array_key_exists($key, $_POST)) {
            $value = $_POST[$key];
        }

        \OLOG\Assert::assert($value != '', 'Missing required POST field ' . $key); // TODO: library used while not mentioned in config

        return $value;
    }

    static public function getOptionalPostValue($key, $default = '')
    {
        $value = '';

        if (array_key_exists($key, $_POST)) {
            $value = $_POST[$key];
        }

        if ($value == '') {
            $value = $default;
        }

        return $value;
    }

}