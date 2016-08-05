<?php

namespace OLOG;

class Assert
{
    static public function assert($value, $message = "")
    {
        if ($value == false) {
            if ($message == ""){
                $message = 'Assertion failed';
            }

            $backtrace_arr = debug_backtrace();

            $code_file_and_line = '';

            if (is_array($backtrace_arr)) {
                if (count($backtrace_arr) > 0) {
                    $last_function_call_trace = $backtrace_arr[0];
                    $code_file_and_line = "[" . $last_function_call_trace['file'] . ":" . $last_function_call_trace['line'] . "]";
                }
            }

            //$message_str = 'Assertion failed: ' . $message;

            $request_uri = '';
            if (array_key_exists('REQUEST_URI', $_SERVER)) {
                $request_uri = '[' . $_SERVER['REQUEST_URI'] . ']';
            }

            $message_arr = [];
            if ($message){
                $message_arr[] = $message;
            }
            if ($code_file_and_line){
                $message_arr[] = $code_file_and_line;
            }
            if ($request_uri){
                $message_arr[] = $request_uri;
            }

            throw new \Exception(implode("\n", $message_arr));
        }
    }
}