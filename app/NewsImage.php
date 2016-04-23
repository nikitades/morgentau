<?php

namespace App;

use App\Image;

class NewsImage extends Image
{
    protected $fillable = [
        'parent_id',
        'ext',
        'width',
        'height',
        'size',
        'url',
        'name',
        'pos',
    ];

    public function scopeAttachmentTo($query, $id)
    {
        $select_fields = [
            'images.id',
            'news_images.pos',
            'images.name',
            'images.filename'
        ];
        foreach (Image::$dimensions as $dimension) {
            list($key, $value) = explode(':', $dimension);
            $select_fields[] = Image::FILENAME_FIELD.'_'.$key.$value;
        }
        return $query->where('parent_id', $id)
            ->orderBy('pos')
            ->join('images', 'news_images.image_id', '=', 'images.id')
            ->select($select_fields);
    }
}
