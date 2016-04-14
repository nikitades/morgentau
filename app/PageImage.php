<?php

namespace App;

use App\Image;

class PageImage extends Image
{
    protected $fillable = [
        'parent_id',
        'ext',
        'width',
        'height',
        'size',
        'content',
        'name',
        'pos',
    ];

    public function scopeAttachmentTo($query, $item)
    {
        return $query->where('parent_id', $item->id)->orderBy('pos')->select('id', 'ext', 'name', 'pos');
    }
}
