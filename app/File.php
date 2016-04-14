<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function url()
    {
        return '/files/'.$this->name;
    }

    public function deleteUrl()
    {
        return '/files/delete/'.$this->name;
    }
}
