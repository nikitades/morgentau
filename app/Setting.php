<?php

namespace App;

class Setting extends CustomModel
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
