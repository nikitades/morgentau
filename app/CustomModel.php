<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomModel extends Model
{

    protected $checkboxes = [];

    public function getShortClass()
    {
        $full_class = explode('\\', $this->getMorphClass());
        return $full_class[sizeof($full_class) - 1];
    }

    public function fill(Array $attributes)
    {
        $attributes = $this->verifyInput($attributes);
        parent::fill($attributes);
        return $this;
    }

    public function verifyInput($data)
    {
        foreach ($this->checkboxes as $key_field) {
            $data[$key_field] = isset($data[$key_field]) ?? 0;
        }
        return $data;
    }
}