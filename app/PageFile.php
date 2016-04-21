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

    public function scopeAttachmentTo($query, $id)
    {
        $select_fields = [
            'files.id',
            'files.name',
            'files.filename'
        ];
        return $query->where('parent_id', $id)
            ->orderBy('pos')
            ->join('files', 'page_files.file_id', '=', 'files.id')
            ->select($select_fields);
    }
}
