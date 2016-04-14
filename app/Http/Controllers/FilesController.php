<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Intervention\Image\Facades\Image;

class FilesController extends Controller
{
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $this->scan($name, function($item) {
            header('Content-Type: '.$item->mime);
            header('Content-Disposition: attachment; filename="'.$item->original_name.'"');
            print $item->content;
        }, 'file');
        \App::abort(404);
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
        }, 'file');
        return redirect()->back();
    }

    /**
     * Scans the request inputs for the files and saves as the file of the given item.
     *
     * @param $request
     * @param $item
     */
    public function saveFiles($request, $item)
    {
        foreach ($request->file() as $name => $source) {
            if (substr($name, 0, 4) == 'file') {
                $entity = 'App\\' . substr($name, 5);
                $ext = $source->guessExtension();
                $mime = $source->getMimeType();
                $originalName = $source->getClientOriginalName();

                $file = new $entity;

                $existingFiles = $entity::where('parent_id', $item->id)->get();

                $file->pos = sizeof($existingFiles) + 1;
                $file->parent_id = $item->id;
                $fc = new FilesController();
                $file->name = $fc->makeReallyUniqueName('file');
                $file->original_name = $originalName;
                $file->ext = $source->getClientOriginalExtension();
                $file->size = $source->getClientSize();
                $file->mime = $mime;
                $file->content = File::get($source);

                $file->save();
            }
        }
    }
}
