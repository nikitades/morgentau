<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Starts the reordering of the items according to their 'pos'.
     *
     * @param $items
     */
    public static function reorderItems($items, $i = 1)
    {
        foreach ($items as $item) {
            $item->pos = $i++;
            $item->save();
        }
    }

    /**
     * Generates the unique item name amongst the defined model.
     *
     * @param $entity
     * @return string
     */
    public static function makeUniqueName($entity)
    {
        $name = substr(md5(uniqid(rand(), true)), 0, 12);
        $existing = $entity::where('name', $name)->get();
        if (sizeof($existing)) {
            self::makeUniqueName($entity);
        } else {
            return $name;
        }
    }

    /**
     * Scans all the models with 'name' field to check that the name is truly unique - amongst all the models, not only through the name recipient's model.
     *
     * @param bool $prefix
     * @return string
     * @internal param bool $name
     */
    public function makeReallyUniqueName($prefix = false)
    {
        $name = substr(md5(uniqid(rand(), true)), 0, 12);
        $item = $this->scan($name, function($item) {
            return $item;
        }, $prefix);
        if ($item) {
            $this->makeReallyUniqueName($prefix);
        } else {
            return $name;
        }
    }

    public function makeReallyUniqueNameFromString($name, $prefix = false)
    {
        $item = $this->scan($name, function($item) {
            return $item;
        }, $prefix);
        if ($item) {
            return redirect()->back()->withErrors(['Файл с таким названием уже существует!']);
        } else {
            return $name;
        }
    }

    /**
     * Scans all the models for the defined name and executes the given method upon it.
     * Gives 404 if no item found.
     *
     * @param $name
     * @param $callback
     * @param bool $prefix
     * @return mixed
     */
    public function scan($name, $callback, $prefix = false)
    {
        $modelsList = [];
        $dir = '../app';
        if ($modelsDir = opendir($dir)) {
            while (($file = readdir($modelsDir)) !== false) {
                if (is_file($dir . '/' . $file) && ($prefix ? str_contains($file, ucfirst($prefix)) : true)) {
                    $modelsList[] = pathinfo($dir . '/' . $file)['filename'];
                }
            }
        }

        foreach ($modelsList as $model) {
            $class = 'App\\' . $model;
            $item = new $class;
            $item->getTable();
            if (Schema::hasColumn($item->getTable(), 'name') && Schema::hasColumn($item->getTable(), 'ext')) {
                $item = $class::where('name', $name)->first();
                if ($item) {
                    return $callback($item);
                }
            }
        }
        return false;
    }

}
