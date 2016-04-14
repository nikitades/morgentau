<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
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
