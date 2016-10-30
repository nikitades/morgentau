<?php

namespace App;

class PageTree extends CustomModel
{
    protected $fillable = [
        'ancestor',
        'descendant',
        'depth'
    ];
}
