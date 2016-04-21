<?php

namespace App;

use App\Image;

class NewsImage extends Image
{
    public function scopeAttachmentTo($query, $id)
    {
        return $query->where('parent_id', $id)->orderBy('pos')->select('id', 'pos');
    }
}
