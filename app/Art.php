<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    protected $fillable = [
        'id',
        'is_active',
        'name',
        'artwork_url',
        'page_content',
        'publish_date',
    ];

    public function scopeAdminList($query)
    {
        return $query->where('name', '!=', '')->orderBy('publish_date', 'desc');
    }

    public function scopeIndexList($query)
    {
        return $query->where('is_active', true)->limit(10)->orderBy('publish_date', 'desc');
    }

    public static function images()
    {
        return [
            'Обложка' => 'ArtCoverImage',
            'Изображение объекта' => 'ArtImage'
        ];
    }

    public static function files()
    {
        return [
            //
        ];
    }

    public function cover()
    {
        return $this->hasOne('App\ArtCoverImage', 'parent_id');
    }

    public function url()
    {
        return $this->artwork_url ? '/arts/' . $this->artwork_url : '';
    }

    public function setPublishDateAttribute($date) {
        $this->attributes['publish_date'] = Carbon::createFromFormat('Y-m-d', $date);
    }

}
