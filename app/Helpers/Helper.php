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

    // Nicked from Drupal :)
    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    public static function file_upload_max_size() {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post max size
            $post_max_size = Helper::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
               $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce.
            // Except if upload_max_size is zero
            // which indicates no limit
            $upload_max = Helper::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }


    public static function file_upload_max_size_readable() {
        static $max_size = -1;
        if ($max_size < 0) {
            // Start with post_max_size
            $post_max_size = Helper::parse_size(ini_get('post_max_size'));

            if($post_max_size > 0) {
                $max_size = ini_get('post_max_size');
            }

            // if upload_max_size is less, then reduce
            // Except if upload_max_size is zero,
            // which indicates no limit

            $upload_max = Helper::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = ini_get('upload_max_filesize');
            }
        }

        return $max_size;
    }

    public static function parse_size($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from size
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.

        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
}