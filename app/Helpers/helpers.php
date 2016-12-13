<?php

use App\Facades\Ajax;

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

if (!function_exists('error')) {
    function error($str)
    {
        Ajax::$errors[] = $str;
        return false;
    }
}

if (!function_exists('ar')) {
    function ar($str)
    {
        $args = func_get_args();
        if (sizeof($args) == 2) {
            Ajax::$errors[$args[0]] = $args[1];
        } else Ajax::$errors[] = $args[0];
        return false;
    }
}

if (!function_exists('ad')) {
    function ad()
    {
        $args = func_get_args();
        if (sizeof($args) == 2) {
            Ajax::$debug[$args[0]] = $args[1];
        } else Ajax::$debug[] = $args[0];
        return false;
    }
}

if (!function_exists('ajax')) {
    function ajax($data)
    {
        $args = func_get_args();
        if (sizeof($args) == 2) {
            Ajax::$data[$args[0]] = $args[1];
        } else Ajax::$data[] = $args[0];
        return true;
    }
}

if (!function_exists('ah')) {
    function ah($data)
    {
        Ajax::$html[] = $data;
        return true;
    }
}

if (!function_exists('check_if_multidimensional_array')) {
    function check_if_multidimensional_array($array)
    {
        return count($array) == count($array, COUNT_RECURSIVE);
    }
}

if (!function_exists('validate_true_with_message')) {
    function validate_true_with_message($items)
    {
        if (!is_array($items[0]) || isset($items['item'])) $items = [$items];
        $result = [];
        foreach ($items as $item) {
            if ($item['check'] !== true) $result[] = $item['message'];
        }
        return sizeof($result) ? $result : true;
    }
}

function imagecreatefromfile($filename)
{
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "' . $filename . '" not found.');
    }
    switch (exif_imagetype($filename)) {
        case IMAGETYPE_GIF:
            return imagecreatefromgif($filename);
            break;
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($filename);
            break;
        case IMAGETYPE_PNG:
            return imagecreatefrompng($filename);
            break;
        default:
            return false;
            break;
    }
}