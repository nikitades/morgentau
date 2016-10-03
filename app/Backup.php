<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    const FOLDER = 'backups';

    protected $fillable = [
        'type',
        'size',
        'folder',
        'sql',
        'tar',
    ];

    public function scopeAdminList($query)
    {
        //TODO: change this query type to fetching folders with acquiring the date right from its name
        return $query->orderBy('created_at');
    }

    public function hrType()
    {
        $types = [
            1 => 'Полный',
            2 => 'База',
            3 => 'Файлы'
        ];

        return $types[$this->type];
    }
}
