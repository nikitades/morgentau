<?php

namespace App;

class View extends CustomModel
{
    const PAGE_VIEWS_FOLDER = '../resources/views/pages/';

    protected $fillable = [
        'name',
        'view'
    ];

    public static $validation = [
        'name' => 'required'
    ];

    public function scopeAdminList($query)
    {
        return $query->where('view', '!=', '""')->orderBy('pos');
    }

    public static function viewFilesList()
    {
        $files_list = scandir(self::PAGE_VIEWS_FOLDER);
        $output = [];
        foreach ($files_list as $file) {
            if (substr($file, -10) == '.blade.php') {
                $basename = substr($file, 0, -10);
                $output['pages.'.$basename] = $basename;
            }
        }
        return $output;
    }
}
