<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'newsitem_url',
        'short',
        'full',
        'date',
        'hot',
    ];

    public static function images()
    {
        return [
            'Картинка новости' => 'NewsImage'
        ];
    }

    public function url()
    {
        return $this->newsitem_url ? '/news/'.$this->newsitem_url : '';
    }

    public function scopeAdminList($query)
    {
        return $query->orderBy('hot', 'desc')->orderBy('date', 'desc');
    }

    public function scopePageList($query)
    {
        return $query->orderBy('hot', 'desc')->orderBy('date', 'desc');
    }

    public function scopeHot($query)
    {
        return $query->where('hot', true)->orderBy('date', 'desc');
    }

    public function setDateAttribute($date) {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
    }
}
