<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = [
        'name',
        'type',
        'pos',
        'value',
        'code'
    ];

    public function scopeAdminList($query)
    {
        return $query->orderBy('pos');
    }

    public function types()
    {
        return [
            'string' => 'строка',
            'text' => 'текст',
            'boolean' => 'да/нет',
        ];
    }
}
