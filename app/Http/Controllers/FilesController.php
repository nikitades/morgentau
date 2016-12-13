<?php

namespace App\Http\Controllers;

use App\File as Basefile;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{

    const FAKE_NAMES = true;
    const NO_SUCCESS_MESSAGES = true;

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
     * Currently does nothing.
     *
     * @param $name
     * @return nothing
     * @internal param int $id
     */
    public function show($name)
    {
        //
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
    public function destroy($id)
    {
        self::deleteFile($id);
    }

    /**
     * Deletes the file entity and the linked file.
     *
     * @param $id
     * @return mixed
     */
    public static function deleteFile($id)
    {
        $file = Basefile::findOrFail($id);
        $filepath = '.' . Basefile::FILE_STASH . '/' . $file->filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        } else {
            Session::flash('error', Lang::get('global.some-files-were-not-found') . ' (' . $filepath . ')');
        }
        $file->delete();
        return redirect()->back()->with('success-message', Lang::get('global.successfully-removed'));
    }


    /**
     * Checks the needed folders for existence. Creates if needed.
     */
    public static function checkRequiredFilesFolders()
    {
        foreach (Basefile::$required_files_folders as $folder) {
            if (!file_exists('.' . $folder)) {
                mkdir('.' . $folder);
            }
        }
    }

    /**
     * Scans the request inputs for the files and saves as the file of the given item.
     *
     * @param $request
     * @param $item
     */
    public static function saveFiles($request, $item, $fakeNames = false, $no_messages = false)
    {
        self::checkRequiredFilesFolders();
        foreach ($request->file() as $fileFieldName => $file) {

            if (substr($fileFieldName, 0, 4) == Basefile::FILE_PREFIX) {
                $entity = 'App\\' . substr($fileFieldName, 5);
            } else {
                continue;
            }

            //checking the correct mime
            $validator = Validator::make($request->all(), [
                $fileFieldName => 'mimes:' . implode(',', Basefile::$allowed_types) . '|max:' . Basefile::FILE_MAX_FILESIZE
            ]);

            if ($validator->fails()) {
                return clever_redirect($request, '/admin/pages')->withErrors($validator);
            }

            //assigning the fields
            $fileItem = new Basefile;

            $filename = $fakeNames ?
                bin2hex(openssl_random_pseudo_bytes(32)) . '.' . $file->getClientOriginalExtension() :
                $file->getClientOriginalName();


            if (file_exists('.' . Basefile::FILE_STASH . '/' . $filename)) {
                return redirect()->back()->withErrors([Lang::get('global.file-already-exists')]);
            }

            $fileItem->ext = $file->getClientOriginalExtension();
            $fileItem->name = basename($filename);
            $fileItem->filename = $filename;
            $fileItem->size = $file->getClientSize();
            $fileItem->mime = $file->getMimeType();

            //saving the file to folder
            if (!$file = $file->move('.' . Basefile::FILE_STASH, $fileItem->filename)) {
                return redirect()->back()->withErrors([Lang::get('global.cant-save-file')]);
            }

            //saving file itself
            $fileItem->save();

            //saving file link:
            $file_link = new $entity;
            $file_link->pos = sizeof($entity::attachmentTo($item->id)->get()) + 1;
            $file_link->parent_id = $item->id;
            $file_link->file_id = $fileItem->id;
            $file_link->save();

            if (!$no_messages) Session::flash('success-message', Lang::get('global.successfully-saved'));
        }
    }
}
