<?php

namespace OLOG;

class CheckClassInterfaces
{
    /**
     * @param $class_name string Имя класса.
     * @param $interface_class_name string Имя интерфейса
     * @throws \Exception
     */
    static public function exceptionIfClassNotImplementsInterface($class_name, $interface_class_name)
    {
        //$model_class_interfaces_arr = class_implements($class_name);

        //$message = 'Class ' . $class_name . ' does not implement interface ' . $interface_class_name;

        //\OLOG\Assert::assert($model_class_interfaces_arr, $message);
        //\OLOG\Assert::assert(array_key_exists($interface_class_name, $model_class_interfaces_arr), $message);
        Assert::assert(
            self::classImplementsInterface($class_name, $interface_class_name),
            'Class ' . $class_name . ' does not implement interface ' . $interface_class_name
        );
    }

    static public function classImplementsInterface($class_name, $interface_class_name)
    {
        $model_class_interfaces_arr = class_implements($class_name);

        if (array_key_exists($interface_class_name, $model_class_interfaces_arr)){
            return true;
        }

        return false;
    }
}