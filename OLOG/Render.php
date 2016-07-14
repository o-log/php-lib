<?php

namespace OLOG;

class Render
{
    /**
     * Берет из debug_backtrace путь к вызывающему файлу и подключает шаблон относительно этого пути.
     * Это сделано для сокращения путей к шаблонам в коде.
     * @param $template_file string путь к шаблону относительно папки, в которой лежит вызывающий файл. Например: templates/page.tpl.php
     * @param array $variables ассоциативный массив переменных, которые будут переданы в шаблон
     * @return string
     */
    public static function callLocaltemplate($template_file, $variables = array())
    {
        //
        // находим шаблон
        //

        $cb_arr = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
        $caller_obj = array_shift($cb_arr);
        Assert::assert($caller_obj);

        $caller_path = $caller_obj['file'];
        $caller_path_arr = pathinfo($caller_path);

        $caller_dir = $caller_path_arr['dirname'];

        $full_template_path = $caller_dir . DIRECTORY_SEPARATOR . $template_file;

        //
        // вызываем шаблон
        //

        extract($variables, EXTR_SKIP);  // Extract the variables to a local namespace
        ob_start();                      // Start output buffering
        require $full_template_path;      // Include the template file
        $contents = ob_get_contents();   // Get the contents of the buffer
        ob_end_clean();                  // End buffering and discard

        return $contents;                // Return the contents
    }
}
