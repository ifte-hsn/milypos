<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Watson\Validating\ValidatingTrait;
use App\Models\User;

class Setting extends Model
{
    use Notifiable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    protected $rules = [
        'qr_text'             => 'max:31|nullable',
        'thumbnail_max_h'     => 'numeric|max:500|min:25',
        'website'             => 'nullable|url',
        'email'               => 'nullable|email'
    ];

    protected $fillable = [
        'logo',
        'login_logo',
        'favicon',
        'site_name',
        'email',
        'phone',
        'fax',
        'website',
        'vat_no',
        'bank_account_no',
        'address',
        'additional_footer_text',
        'brand',
        'header_color',
        'per_page',
        'qr_code',
        'qr_text',
        'thumbnail_max_h',
        'barcode_type',
        'alt_barcode',
        'alt_barcode_enabled',
        'default_currency',
        'custom_css',
        'locale',
        'date_display_format',
        'time_display_format',
    ];


    public static function getSettings()
    {
        static $static_cache = null;

        if(!$static_cache) {
            if(Schema::hasTable('settings')) {
                $static_cache = Setting::first();
            }
        }

        return $static_cache;
    }


    public static function setupCompleted()
    {
        $users_table_exists = Schema::hasTable('users');
        $settings_table_exists = Schema::hasTable('settings');

        if($users_table_exists && $settings_table_exists) {
            $usercount = User::withTrashed()->count();
            $settingsCount = Setting::count();

            return ($usercount > 0 && $settingsCount > 0);
        }
        return false;
    }

    /**
     *
     * @Author A. Gianotto <snipe@snipe.net>
     * @credit A. Gianotto <snipe@snipe.net>
     *
     * Escape the custom CSS, and then un-escape the greater than symbol
     * So it can work with direct descendant characters for bootstrap
     * menu overrides like:
     *
     * .skin-blue .sidebar-menu>li.active>a, .skin-blue .sidebar-menu>li:hover>a
     *
     * IMPORTANT: do not remove the e() escaping here, as we output raw in the blade.
     *
     * @return string escaped CSS
     */
    public function showCustomCss()
    {
        $custom_css = Setting::getSettings()->custom_css;
        $custom_css = e($custom_css);

        $custom_css = str_ireplace('script', 'SCRIPTS-NOT-ALLOWED-HERE', $custom_css);
        $custom_css = str_replace('&gt;', '>', $custom_css);
        return $custom_css;
    }

    /**
     * @credit SnipeIt
     * @author Mogilev Arseny
     *
     * Converts bytes into human readable file size.
     */

    public static function fileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $result = "0B";
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" =>"GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            )
        );

        foreach ($arBytes as $arItem) {
            if($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = round($result, 2) . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

}
