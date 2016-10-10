<?php


namespace OLOG;


class FilePath
{
    public static function constructPath($file_path_parts_arr, $relative = false)
    {
        $proper_segments = [];
        foreach ($file_path_parts_arr as $part) {
            $segments = explode(DIRECTORY_SEPARATOR, $part);
            $segments = array_filter($segments, function ($v, $k) {
                return (bool)(trim($v));
            }, ARRAY_FILTER_USE_BOTH);
            $proper_segments = array_merge($proper_segments, $segments);
        }
        $path = implode(DIRECTORY_SEPARATOR, $proper_segments);
        return $relative ? $path : (DIRECTORY_SEPARATOR . $path);
    }
}