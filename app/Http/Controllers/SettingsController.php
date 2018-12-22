<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Image;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }
    public function getBranding()
    {
        $settings = Setting::first();
        return view('settings.branding', compact('settings'));
    }


    public function postBranding(Request $request) {

        $request->validate([
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image'
        ]);


        $setting = Setting::first();

        $setting->company_name = $request->input('company_name');
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

        if ($setting->save()) {
           return redirect()->route('settings.index')->with('success', __('settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }
}
