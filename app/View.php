<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'name',
        'view'
    ];

    public function scopeAdminList($query)
    {
        return $query->where('view', '!=', '""')->orderBy('pos');
    }
}
