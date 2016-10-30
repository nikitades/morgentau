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

    public function scopeAdminList($query)
    {
        return $query->where('name', '!=', '""')->orderBy('pos');
    }
}
