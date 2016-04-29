<?php

if (!function_exists('delTree')) {
    /**
     * Recursively removes the folder and all the files in it.
     *
     * @param $dir
     * @return bool
     */
    function delTree($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}

if (!function_exists('de')) {
    function de($command, $dump = false)
    {
        $output = [];
        exec($command, $output);
        if ($dump) {
            dd($output);
        }
    }
}

if (!function_exists('name')) {
    function name($length)
    {
        return substr(md5(uniqid(rand(), true)), 0, $length);
    }
}

if (!function_exists('unique_name')) {
    function uniqueName($folder, $length)
    {
        $name = name($length);
        $files_list = scandir($folder);
        foreach ($files_list as $file) {
            if ($file != $name) return $name;
        }
        uniqueName($folder, $length);
    }
}

if (!function_exists('reorder_items')) {
    function reorder_items($items, $i = 1)
    {
        foreach ($items as $item) {
            $item->pos = $i++;
            $item->save();
        }
    }
}

if (!function_exists('clever_redirect')) {
    function clever_redirect($request, $url = false)
    {
        return redirect($request->direction == 'stay' ? $request->current_url : $url);
    }
}