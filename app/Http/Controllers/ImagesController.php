<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Lang;
use App\Image;
use Illuminate\Support\Facades\Session;
use Validator;
use Intervention\Image\Facades\Image as InterImage;

class ImagesController extends Controller
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
        $image = Image::findOrFail($id);
        $errors = [];
        $not_removed = [];
        foreach (Image::$dimensions as $dimension) {
            list($key, $value) = explode(':', $dimension);
            $filepath = Image::FILENAME_FIELD . '_' . $key . $value;
            $filepath = '.' . Image::IMAGES_STASH . '/' . $image->$filepath;
            if (file_exists($filepath)) {
                if (!unlink($filepath)) $not_removed[] = $filepath;
            } else {
                $errors[] = $filepath.' ('.$key.':'.$value.')';
            }
        }
        $filepath = Image::FILENAME_FIELD;
        $filepath = '.' . Image::IMAGES_STASH . '/' . $image->$filepath;
        if (file_exists($filepath)) {
            if (!unlink($filepath)) $not_removed[] = $filepath;
        } else {
            $errors[] = $filepath;
        }
        $entity = $image->entity;
        $originalImage = $entity::where('image_id', $image->id)->first();
        $images = $entity::where('parent_id', $originalImage->parent_id)->where('id', '!=', $originalImage->id)->get();
        reorder_items($images);
        $image->delete();

        if (sizeof($not_removed)) {
            Session::flash('error', Lang::get('global.some-files-were-not-found') . ' (' . implode(', ', $not_removed) . ')');
        }
        if (sizeof($errors)) {
            return redirect()->back()->withErrors([Lang::get('global.some-files-were-not-found') . ' (' . implode(', ', $errors) . ')']);
        } else {
            return redirect()->back()->with('success-message', Lang::get('global.successfully-removed'));
        }
    }

    /**
     * Check if all the required folders exist. Creates if not.
     */
    public static function checkRequiredImagesFolders()
    {
        foreach (Image::$required_images_folders as $folder) {
            if (!file_exists('.' . $folder)) {
                mkdir('.' . $folder);
            }
        }
    }

    /**
     * Saves the images attached to the model.
     *
     * @param $request
     * @param $item
     */
    public static function saveImages($request, $item)
    {
        self::checkRequiredImagesFolders();
        foreach ($request->file() as $imageFieldName => $file) {

            if (substr($imageFieldName, 0, 5) == Image::IMAGE_PREFIX) {
                $entity = 'App\\' . substr($imageFieldName, 6);
            } else {
                continue;
            }

            //checking the correct mime
            $validator = Validator::make($request->all(), [
                $imageFieldName => 'mimes:' . implode(',', Image::$allowed_types) . '|max:' . Image::IMAGE_MAX_FILESIZE
            ]);

            if ($validator->fails()) {
                return clever_redirect($request, '/admin/pages')->withErrors($validator);
            }


            //assigning the fields
            $image = new Image;
            $image->ext = $file->getClientOriginalExtension();
            $image->basename = uniqueName('.' . Image::IMAGES_STASH, 12);
            $image->name = $file->getClientOriginalName();
            if (file_exists('.' . Image::IMAGES_STASH . '/' . $image->name)) return redirect()->back()->withErrors([Lang::get('global.file-already-exists')]);
            $image->filename = $image->basename . '.' . $image->ext;
            $image->size = $file->getClientSize();
            $image->mime = $file->getMimeType();
            $size = getimagesize($file->getPathname());
            $image->width = $size[0];
            $image->height = $size[1];
            $image->entity = $entity;
            //saving the file to folder
            if (!$file = $file->move('.' . Image::IMAGES_STASH, $image->filename)) {
                return redirect()->back()->withErrors([Lang::get('global.cant-save-image')]);
            }
            //fetching the II object to work with
            $interImage = InterImage::make('.' . Image::IMAGES_STASH . '/' . $image->filename);

            //TODO: Probably I'll need the entity-defined images_stash folder and filename_field value. So, may be I will make this controller and every image-related sibling use self:: instead of Image::.

            //saving all the dimensions
            $dimensions = Image::$dimensions;
            rsort($dimensions);
            foreach ($dimensions as $dimension) {
                list($key, $value) = explode(':', $dimension);
                $image_name = uniqueName('.' . Image::IMAGES_STASH, 12) . '.' . $image->ext;
                $imagefile = $interImage->fit(ceil($image->width / ($image->height / $value)), $value);
                $imagefile->save('.' . Image::IMAGES_STASH . '/' . $image_name);
                $field_name = Image::FILENAME_FIELD . '_' . $key . $value;
                $image->$field_name = $image_name;
            }

            //saving image itself
            $image->save();

            //saving image link:
            $image_link = new $entity;
            $image_link->pos = sizeof($entity::attachmentTo($item->id)->get()) + 1;
            $image_link->parent_id = $item->id;
            $image_link->image_id = $image->id;
            $image_link->save();

            Session::flash('success-message', Lang::get('global.successfully-saved'));
        }

        //reposition images:
        self::reposition($request, $item);
    }

    /**
     * Move the image according to the input data.
     *
     * @param $request
     * @param $item
     */
    public static function reposition($request, $item)
    {
        $listToReassign = [];
        foreach ($request->toArray() as $key => $val) {
            if (substr($key, 0, strlen(Image::REPOSITION_TAG)) == Image::REPOSITION_TAG) {
                if ($val) $listToReassign[$key] = $val;
            }
        }
        $entitiesToReorder = [];
        foreach ($listToReassign as $key => $val) {
            if (!$val) continue;
            list( , $entity, $id) = explode(':', $key);
            $image = $entity::where('image_id', $id)->first();
            $imageOriginalPos = $image->pos;
            $image->pos = $val;
            $image->save();
            if ($imageOriginalPos < $val) {
                $imagesBelow = $entity::where('pos', '<=', $val)->where('parent_id', $item->id)->where('image_id', '!=', $id)->orderBy('pos')->get();
                foreach ($imagesBelow as $imageToIncrement) {
                    $imageToIncrement->pos--;
                    $imageToIncrement->save();
                }
            } else {
                $imagesAbove = $entity::where('pos', '>=', $val)->where('parent_id', $item->id)->where('image_id', '!=', $id)->orderBy('pos')->get();
                foreach ($imagesAbove as $imageToIncrement) {
                    $imageToIncrement->pos++;
                    $imageToIncrement->save();
                }
            }
            $entitiesToReorder[] = $entity;
        }
        foreach ($entitiesToReorder as $entity) {
            $itemsToReorder = $entity::where('parent_id', $item->id)->orderBy('pos')->get();
            reorder_items($itemsToReorder);
        }
    }
}
