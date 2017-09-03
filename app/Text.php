<?php

namespace App;

class Text extends CustomModel
{

    protected $fillable = [
        'name',
        'code',
        'text_content',
        'html',
        'pos'
    ];

    protected $checkboxes = [
        'html'
    ];

    public function scopeAdminList($query)
    {
        return $query->where('name', '!=', '""')->orderBy('pos');
    }
}
