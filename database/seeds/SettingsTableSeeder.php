<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        Setting::create([
            'site_name' => 'Mily POS',
            'site_name_abbr' => 'MPOS',
            'default_currency' => 'USD'
        ]);
    }
}
