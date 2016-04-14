<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    public static function fullDate($date, $lang = 'ru') {

        $months = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];

        $date = strtotime($date);
        switch ($lang) {
            case 'ru':
                return date('d', $date).' '.$months[date('m', $date)].' '.date('Y', $date);
                break;
        }
    }

    public static function monthsRuShort($i)
    {
        $months = [
            '01' => 'янв',
            '02' => 'фев',
            '03' => 'мар',
            '04' => 'апр',
            '05' => 'мая',
            '06' => 'июн',
            '07' => 'июл',
            '08' => 'авг',
            '09' => 'сен',
            '10' => 'окт',
            '11' => 'ноя',
            '12' => 'дек',
        ];

        return $months[str_pad($i, 2, ' ', STR_PAD_LEFT)];
    }

}
