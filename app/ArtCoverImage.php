<?php

namespace App;

use App\Image;

class ArtCoverImage extends Image
{
    public function scopeAttachmentTo($query, $id)
    {
        $select_fields = [
            'images.id',
            'art_cover_images.pos',
            'images.name',
            'images.filename'
        ];
        foreach (Image::$dimensions as $dimension) {
            list($key, $value) = explode(':', $dimension);
            $select_fields[] = Image::FILENAME_FIELD.'_'.$key.$value;
        }
        return $query->where('parent_id', $id)
            ->orderBy('pos')
            ->join('images', 'art_cover_images.image_id', '=', 'images.id')
            ->select($select_fields);
    }

    public function art()
    {
        return $this->belongsTo('App\Art');
    }

    public function source()
    {
        return $this->hasOne('App\Image', 'id', 'parent_id');
    }

}
