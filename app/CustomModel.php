<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomModel extends Model
{
    public function getShortClass()
    {
        $full_class = explode('\\', $this->getMorphClass());
        return $full_class[sizeof($full_class) - 1];
    }
}