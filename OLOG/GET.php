<?php

namespace OLOG;

class GET {

    static public function required($key) {
        $value = '';

        if (array_key_exists($key, $_GET)) {
            $value = $_GET[$key];
        }

        \OLOG\Assert::assert($value != '', 'Missing required GET field ' . $key); // TODO: library used while not mentioned in config

        return $value;
    }

    static public function optional($key, $default = '') {
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
