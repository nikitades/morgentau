<?php

namespace App;

use App\Image;

class NewsImage extends Image
{
    public function scopeAttachmentTo($query, $item)
    {
        return $query->where('parent_id', $item->id)->orderBy('pos')->select('id', 'ext', 'name', 'pos');
    }
}
