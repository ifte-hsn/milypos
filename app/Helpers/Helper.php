<?php


namespace App\Helpers;


use App\Models\Setting;
use Carbon\Carbon;

class Helper
{
    public static function getFormattedDateObject($date, $type="datetime", $array = true)
    {
        if($date == '') {
            return null;
        }

        $settings = Setting::getSettings();
        $tempDate = new Carbon($date);

        if($type == 'datetime') {
            $dt['datetime'] = $tempDate->format('Y-m-d H:i:s');
            $dt['formatted'] = $tempDate->format($settings->date_display_format);
        } else {
            $dt['date'] = $tempDate->format('Y-m-d');
            $dt['formatted'] = $tempDate->format($settings->date_display_format);
        }

        if($array = true) {
            return $dt;
        }

        return $dt['formatted'];
    }
}