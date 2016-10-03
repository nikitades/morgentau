<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTree extends Model
{
    protected $fillable = [
        'ancestor',
        'descendant',
        'depth'
    ];
}
