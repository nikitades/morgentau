<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hierarchy extends Model
{
    protected $fillable = [
        'root',
        'pages'
    ];

    public function showList($parentId, $itemId)
    {
        $list = [];
        if ($parentId == $this->root['id'] || (!$parentId && $this->root['id'] == '')) $list[$this->root['id']] = $this->root['name'];
        foreach ($this->pages as $id => $page) {
            if ($id == $itemId) continue;
            $list[$id] = $page;
        }
        return $list;
    }
}
