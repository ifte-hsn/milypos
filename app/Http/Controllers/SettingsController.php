<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $this->authorize('update_settings', Setting::class);

        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function getBranding()
    {
        $this->authorize('update_settings', Setting::class);
        $settings = Setting::first();
        return view('settings.branding', compact('settings'));
    }


    public function postBranding(Request $request)
    {

        $this->authorize('update_settings', Setting::class);
        $request->validate([
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image'
        ]);


        $setting = Setting::first();

        $setting->site_name = $request->input('site_name');
        $setting->email = $request->input('email');
        $setting->phone = $request->input('phone');
        $setting->fax = $request->input('fax');
        $setting->website = $request->input('website');
        $setting->vat_no = $request->input('vat_no');
        $setting->bank_account_no = $request->input('bank_account_no');
        $setting->address = $request->input('address');
        $setting->additional_footer_text = $request->input('additional_footer_text');
        $setting->brand = $request->input('brand', 'text_only');


        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $file_name = "logo.".$image->getClientOriginalExtension();
            $path = public_path('uploads');

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(200, 50, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path.'/'.$file_name);
            } else {
                $image->move($path, $file_name);
            }

            $setting->logo = $file_name;
        }

        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $file_name = "favicon.".$image->getClientOriginalExtension();
            $path = public_path('uploads');

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(48, 48, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path.'/'.$file_name);
            } else {
                $image->move($path, $file_name);
            }

            $setting->favicon = $file_name;
        }


        if ($request->hasFile('login_logo')) {
            $image = $request->file('login_logo');
            $file_name = "login_logo.".$image->getClientOriginalExtension();
            $path = public_path('uploads');

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(200, 50, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path.'/'.$file_name);
            } else {
                $image->move($path, $file_name);
            }

            $setting->login_logo = $file_name;
        }

        if ($setting->save()) {
           return redirect()->route('settings.index')->with('success', __('settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    public function getLocalization()
    {
        $this->authorize('update_settings', Setting::class);


        $currencies = Currency::all();
        $settings = Setting::first();
        return view('settings.localization', compact('settings', 'currencies'));
    }

    public function postLocalization(Request $request)
    {
        $this->authorize('update_settings', Setting::class);
        if (is_null($setting = Setting::first())) {
            return redirect()->route('settings.localization')->with('error', trans('settings/message.update.error'));
        }

        $setting->currency_id = $request->input('currency_id');
        $setting->date_display_format = $request->input('date_display_format');
        $setting->time_display_format = $request->input('time_display_format');

        if ($setting->save()) {
            return redirect()->route('settings.localization')
                ->with('success', trans('settings/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }
}
