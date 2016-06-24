<?php
namespace OLOG;

class ConfWrapper
{
    static $config_arr = null;

    static public function assignConfig($config_arr)
    {
        self::$config_arr = $config_arr;
    }

    static public function get()
    {
        \OLOG\Assert::assert(self::$config_arr);
        return self::$config_arr;
    }

    /**
     * @param $path
     * @return mixed
     * @throws \Exception
     */
    static public function getRequiredValue($path)
    {
        $config_arr = self::get();

        return self::getRequiredSubvalue($config_arr, $path);
    }

    /**
     * @param $arr
     * @param $path
     * @return mixed
     * @throws \Exception
     */
    static public function getRequiredSubvalue($arr, $path)
    {
        Assert::assert(!empty($path));
        Assert::assert(is_array($arr));

        $value = $arr;

        $parts = explode(".", $path);

        foreach ($parts as $part) {
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                throw new \Exception('missing config key');
            }
        }

        return $value;
    }

    /**
     * @param $arr
     * @param $path
     * @param string $default
     * @return mixed
     */
    static public function getOptionalSubvalue($arr, $path, $default = '')
    {
        if (empty($path)) {
            return $default;
        }

        $value = $arr;

        $parts = explode(".", $path);

        foreach ($parts as $part) {
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                // key doesn't exist, fail
                return $default;
            }
        }

        return $value;
    }

    /**
     * @param $path
     * @param string $default
     * @return mixed
     */
    static public function getOptionalValue($path, $default = '')
    {
        $config_arr = self::get();

        return self::getOptionalSubvalue($config_arr, $path, $default);
    }

    /**
     * @deprecated
     *
     * Get value an array by using "root.branch.leaf" notation
     *
     * @param string $path Path to a specific option to extract
     * @param mixed $default Value to use if the path was not found
     * @return mixed
     */
    static public function value($path, $default = '')
    {
        if (empty($path)) {
            return '';
        }

        $value = self::get();

        $parts = explode(".", $path);

        foreach ($parts as $part) {
            if (isset($value[$part])) {
                $value = $value[$part];
            } else {
                // key doesn't exist, fail
                return $default;
            }
        }

        return $value;
    }
}
