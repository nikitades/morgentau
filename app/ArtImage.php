<?php

namespace App;

use App\Image;

class ArtImage extends Image
{
    public function scopeAttachmentTo($query, $id)
    {
        $select_fields = [
            'images.id',
            'art_images.pos',
            'images.name',
            'images.filename'
        ];
        foreach (Image::$dimensions as $dimension) {
            list($key, $value) = explode(':', $dimension);
            $select_fields[] = Image::FILENAME_FIELD.'_'.$key.$value;
        }
        return $query->where('parent_id', $id)
            ->orderBy('pos')
            ->join('images', 'art_images.image_id', '=', 'images.id')
            ->select($select_fields);
    }
}
