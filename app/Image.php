<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function url($type = false, $value = false)
    {
        if ($type && $value) {
            return '/images/'.$this->name.'.'.$this->ext.'?'.$type.'='.$value;
        } else {
            return '/images/'.$this->name.'.'.$this->ext;
        }
    }

    public function deleteUrl()
    {
        return '/images/delete/'.$this->name;
    }
}
