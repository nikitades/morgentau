<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use File;
use Intervention\Image\Facades\Image;

class ImagesController extends Controller
{

    public $images_folder = './images';
    public $cache_folder = './images/cache';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the image by checking the sequence of the models for the unique name.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($name, $ext)
    {
        //Exists in cache folder? Then return the cached file:
        if ($filename = $this->checkIfExists($name, $ext)) {
            $content = file_get_contents($this->cache_folder.'/'.$filename);
            return Image::make($content)->response();
        }

        //If does not exist, build the file, cache and return:
        if (isset($_GET['s'])) {
            $param = ['name' => 'defined', 'size' => $_GET['s']];
        } elseif (isset($_GET['lt'])) {
            $param = [
                'name' => 'lowerThan',
                'size' => $_GET['lt']
            ];
        } elseif (isset($_GET['bt'])) {
            $param = [
                'name' => 'biggerThan',
                'size' => $_GET['bt']
            ];
        } else {
            $param = false;
        }

        $modelsList = [];
        $dir = '../app';
        if ($modelsDir = opendir($dir)) {
            while (($file = readdir($modelsDir)) !== false) {
                if (is_file($dir . '/' . $file)) {
                    $modelsList[] = pathinfo($dir . '/' . $file)['filename'];
                }
            }
        }


        foreach ($modelsList as $model) {
            $class = 'App\\' . $model;
            $item = new $class;
            $item->getTable();
            if (Schema::hasColumn($item->getTable(), 'name') && Schema::hasColumn($item->getTable(), 'ext')) {
                $image = $class::where('name', $name)->where('ext', $ext)->first();
                if ($image) {
                    switch ($param['name']) {
                        case false:
                            file_put_contents($this->cache_folder.'/'.$this->createImageName($image->name, $image->ext, $_GET), $image->content);
                            header("Content-type: " . $image->mime);
                            header("Accept-Ranges: bytes");
                            header("Content-length: " . ($image->size));
                            die($image->content);
                        case 'defined':
                            $size = preg_split('/[:x-|]/', $param['size']);
                            $width = intval($size[0]);
                            $height = intval($size[1]);
                            $preparedImage =  Image::make($image->content);
                            file_put_contents($this->cache_folder.'/'.$this->createImageName($image->name, $image->ext, $_GET), $preparedImage->fit($this->sd($width), $this->sd($height))->response()->content());
                            return $preparedImage->fit($this->sd($width), $this->sd($height))->response();
                            break;
                        case 'lowerThan':
                            $size = intval($param['size']);
                            $dimension = $image->width > $image->height;
                            $preparedImage = Image::make($image->content)->resize($dimension ? $this->sd($size) : null, $dimension ? null : $this->sd($size),function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            file_put_contents($this->cache_folder.'/'.$this->createImageName($image->name, $image->ext, $_GET), $preparedImage->response()->content());
                            return $preparedImage->response();
                            break;
                        case 'biggerThan':
                            $size = intval($param['size']);
                            $dimension = $image->width > $image->height;
                            $preparedImage = Image::make($image->content)->resize($dimension ? null : $this->sd($size), $dimension ? $this->sd($size) : null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            file_put_contents($this->cache_folder.'/'.$this->createImageName($image->name, $image->ext, $_GET), $preparedImage->response()->content());
                            return $preparedImage->response();
                            break;

                    }
                }
            }
        }
        \App::abort(404);
    }

    public function checkIfExists($name, $ext)
    {
        if (!file_exists($this->images_folder)) {
            mkdir($this->images_folder);
        }
        if (!file_exists($this->cache_folder)) {
            mkdir($this->cache_folder);
        }
        $name = $this->createImageName($name, $ext, $_GET);
        return file_exists($this->cache_folder.'/'.$name) ? $name : false;
    }

    public function createImageName($name, $ext, $get)
    {
        $par = '';
        if (isset($get['s'])) {
            $s = preg_replace('/[-|:]/', 'x', $get['s']);
            $par = '.s-'.$s;
        } elseif (isset($get['lt'])) {
            $par = '.lt-'.$get['lt'];
        } elseif (isset($get['bt'])) {
            $par = '.bt-'.$get['bt'];
        } else {
            $par = '';
        }
        return $name.$par.'.'.$ext;
    }

    /**
     * Secure (the) Dimension. Forbids numbers more than 51 characters long.
     *
     * @param $int
     * @return string
     */
    protected function sd($int)
    {
        return substr($int, 0, 5);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $this->scan($name, function($item) {
            $item->delete();
        }, 'image');
        return redirect()->back();
    }

    /**
     * Saves the images attached to the model.
     *
     * @param $request
     * @param $item
     */
    public function saveImages($request, $item)
    {
        $allowedTypes = [
            'jpeg',
            'png',
            'gif'
        ];

        foreach ($request->file() as $name => $file) {
            if (substr($name, 0, 5) == 'image') {

                $entity = 'App\\' . substr($name, 6);
                $ext = $file->guessExtension();
                $mime = $file->getMimeType();

                if (!in_array($ext, $allowedTypes)) {
                    dd('Прикрепленный файл должнен быть изобажением одного из типов: ' . implode(', ', $allowedTypes));
                }

                $image = new $entity;

                $existingImages = $entity::where('parent_id', $item->id)->get();

                $image->pos = sizeof($existingImages) + 1;
                $image->parent_id = $item->id;
                $ic = new ImagesController();
                $image->name = $ic->makeReallyUniqueName($entity);
                $image->ext = $file->getClientOriginalExtension();
                $image->size = $file->getClientSize();
                $image->mime = $mime;
                $image->content = File::get($file);

                $size = getimagesize($file->getPathname());

                $image->width = $size[0];
                $image->height = $size[1];

                $image->save();
            }
        }
    }

    public function reposition($request, $instance, $url)
    {
        $status = ['status' => 'error', 'msg' => 'Изображение с таким именем не найдено!'];
        $state = false;
        foreach ($request->all() as $name => $val) {
            if (substr($name, 0, 10) == 'reposition' && $val) {
                $state = true;
                $name = substr($name, 11);

                $ic = new ImagesController();
                $data = $ic->scan($name, function($item) {
                    $class = get_class($item);
                    return [$item, $class];
                });

                $item = $data[0];
                $class = $data[1];
//                $itemsAfter = $class::where('pos', '>', $val - 1)->where('name', '!=', $item->name)->get();
//                foreach ($itemsAfter as $itemAfter) {
//                    $itemAfter->pos++;
//                    $itemAfter->save();
//                }
                $existing = $class::where('parent_id', $instance->id)->where('pos', $val)->first();
                $existing->pos = $item->pos;
                $item->pos = $val;
                $item->save();
                $existing->save();
                $this->reorderItems($class::where('parent_id', $instance->id)->where('pos', '>', 0)->orderBy('pos')->get());

                $status['status'] = 'done';
            }
        }
        if (!$state) $status['status'] = 'next';

        if ($status['status'] == 'done') {
            return redirect($request->current_url);
        }
        elseif ($status['status'] == 'next') {
            return $this->cleverRedirect($request, $url);
        }
        else {
            return redirect()->back()->withErrors([$status['msg']]);
        }
    }
}
