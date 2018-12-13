<?php


namespace App\Helpers;


use App\Models\Setting;
use Carbon\Carbon;

class Helper
{

    /**
     * Format the date and time
     *
     * @param $date
     * @param string $type
     * @param bool $array
     * @return string|null
     */
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
    public static function formatStandardApiResponse($status, $payload = null, $messages = null)
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


    /**
     * Introspect into the model validation to see if the field passed is required.
     * This is used by the blade and add a required class into the html element.
     *
     * This is useful to keep form fields in sync with the actual model level
     * validation
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @param $class
     * @param $field
     * @return bool
     */
    public static function checkIfRequired($class, $field) {
        $rules = $class::rules();

        foreach ($rules as $rule_name => $rule) {
            if ($rule_name == $field) {
                if (strpos($rule, 'required') === false) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}