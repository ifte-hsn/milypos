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

    /**
     * Format standard API Response
     *
     * @param $status Status of the operaion
     * @param null $payload
     * @param null $messages
     * @return mixed
     */
    function formatStandardApiResponse($status, $payload = null, $messages = null)
    {
        $array['status'] = $status;
        $array['messages'] = $messages;

        if (($messages) && (is_array($messages)) && (count($messages) > 0)) {
            $array['messages'] = $messages;
        }

        if (($payload)) {
            $array['payload'] = $payload;
        } else {
            $array['payload'] = null;
        }

        return $array;
    }
}