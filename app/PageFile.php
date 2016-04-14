<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\File;

class PageFile extends File
{
    protected $fillable = [
        'parent_id',
        'ext',
        'mime',
        'size',
        'content',
        'name',
        'original_name',
        'pos',
    ];

    public function scopeAttachmentTo($query, $item)
    {
        return $query->where('parent_id', $item->id)->orderBy('pos')->select('id', 'ext', 'name', 'pos', 'original_name');
    }
}
