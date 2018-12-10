<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }
    public function getBranding()
    {
        $setting = Setting::first();
        return view('settings.branding', compact('setting'));
    }
}
