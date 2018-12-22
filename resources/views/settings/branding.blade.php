@extends('layouts.default')
@section('title')
    {{ __('general.update_branding_settings') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('settings.branding') }}"><i class="fa fa-wrench"></i>Settings</a></li>
    <li class="active">{{ __('general.general_settings') }}</li>
@endsection

@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>

    <div class="box box-primary">
        <form action="{{ route('settings.branding') }}" method="post" enctype="multipart/form-data" role="form"
              class="form-horizontal form-label-left">
            @csrf
            <div class="box-body">
                <div class="margin-top"></div>
                <div class="row">

                    <!-- *********************** -->
                    <!--       Company name      -->
                    <!-- ************************ -->


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('company_name') ? 'has-error' : '' }}">
                            <label for="company_name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.company_name') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'company_name')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="company_name" name="company_name" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.company_name') }}"
                                       value="{{ Input::old('company_name', $settings->company_name) }}">
                                {!! $errors->first('company_name', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- *********************** -->
                    <!--       Site name          -->
                    <!-- ************************ -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('site_name') ? 'has-error' : '' }}">
                            <label for="site_name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.site_name') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'site_name')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="site_name" name="site_name" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder=" {{ __('general.site_name') }}"
                                       value="{{ Input::old('site_name', $settings->site_name) }}">
                                {!! $errors->first('site_name', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                    <!-- *********************** -->
                    <!--       LOGO      -->
                    <!-- *********************** -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                            <div class="row">
                                <label for="logo"
                                       class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.logo') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'logo')) ? '<span class="text-danger">*</span>':'' !!}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    @if ($settings->logo)
                                        <img src="{{ url('/') }}/uploads/{{ $settings->logo }}" class="img-thumbnail"
                                             id="imagePreview" style="width: 200px; height: 50px">
                                    @else
                                        <img src="{{ url('/') }}/img/logo_placeholder.png" class="img-thumbnail"
                                             id="imagePreview" style="width: 200px; height: 50px">
                                    @endif
                                </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            </div><!-- .row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input id="logo" name="logo" type="file" class="form-control">
                                    <span class="help-block">Logo dimension should be 200px x 50px</span>
                                    {!! $errors->first('logo', '<span class="alert-msg">:message</span>') !!}
                                </div>
                            </div><!-- .row -->
                        </div><!-- form-group -->
                    </div>

                    <!-- FAVICON -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('favicon') ? 'has-error' : '' }}">

                            <div class="row">
                                <label for="favicon"
                                       class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.favicon') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'favicon')) ? '<span class="text-danger">*</span>':'' !!}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">

                                    @if ($settings->favicon)
                                        <img src="{{ url('/') }}/uploads/{{ $settings->favicon }}" class="img-thumbnail"
                                             id="imagePreview" width="28px" height="28px">
                                    @else
                                        <img src="{{ url('/') }}/img/favicon_placeholder.png" class="img-thumbnail"
                                             id="imagePreview" width="28px" height="28px">
                                    @endif

                                </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            </div><!-- .row -->

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input id="favicon" name="favicon" type="file" class="form-control">
                                    <span class="help-block">Image dimension should be 48px x 48px</span>
                                    {!! $errors->first('favicon', '<span class="alert-msg">:message</span>') !!}
                                </div>
                            </div><!-- .row -->

                        </div><!-- form-group -->
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('brand') ? 'has-error' : '' }}">
                            <label for="brand" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.branding') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'brand')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="brand" id="brand" class="form-control col-md-7 col-xs-12 select2">
                                    <option value="text_only" {{ (isset($setting->brand) && $setting->brand === 'text_only') ? 'selected="selected"':''  }}>{{ __('general.text') }}</option>
                                    <option value="logo_only" {{ (isset($setting->brand) && $setting->brand === 'logo_only') ? 'selected="selected"':''  }}>{{ __('general.logo') }}</option>
                                    <option value="text_logo" {{ (isset($setting->brand) && $setting->brand === 'text_logo') ? 'selected="selected"':''  }}>{{ __('general.text_plus_logo') }}</option>
                                </select>
                                {!! $errors->first('brand', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- ***************************** -->
                    <!--       Company email          -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.company_email') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'email')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" name="email" type="email"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.company_email') }}"
                                       value="{{ Input::old('email', $settings->email) }}">
                                {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- ***************************** -->
                    <!--       Phone         -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.phone') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'phone')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="phone" name="phone" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.phone') }}"
                                       value="{{ Input::old('phone', $settings->phone) }}">
                                {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- ***************************** -->
                    <!--             Fax               -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('fax') ? 'has-error' : '' }}">
                            <label for="fax" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.fax') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'fax')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="fax" name="fax" type="text" class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.fax') }}"
                                       value="{{ Input::old('fax', $settings->fax) }}">
                                {!! $errors->first('fax', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                    <!-- ***************************** -->
                    <!--              Website          -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group  {{ $errors->has('website') ? 'has-error' : '' }}">
                            <label for="website" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.website') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'website')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="website" name="website" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.website') }}"
                                       value="{{ Input::old('website', $settings->website) }}">
                                {!! $errors->first('website', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                    <!-- ***************************** -->
                    <!--             VAT No            -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('vat_no') ? 'has-error' : '' }}">
                            <label for="vat_no" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.vat_no') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'vat_no')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="vat_no" name="vat_no" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.vat_no') }}"
                                       value="{{ Input::old('vat_no', $settings->vat_no) }}">
                                {!! $errors->first('vat_no', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- ***************************** -->
                    <!--       Bank Account No         -->
                    <!-- **************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('bank_account_no') ? 'has-error' : '' }}">
                            <label for="bank_account_no" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.bank_account_no') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'bank_account_no')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="bank_account_no" name="bank_account_no" type="text"
                                       class="form-control col-md-7 col-xs-12"
                                       placeholder="{{ __('general.bank_account_no') }}"
                                       value="{{ Input::old('bank_account_no', $settings->bank_account_no) }}">
                                {!! $errors->first('bank_account_no', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- *********************** -->
                    <!--          Address        -->
                    <!-- *********************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.address') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'address')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="address" id="address" cols="30" rows="10"
                                                  class="form-control col-md-7 col-xs-12">{{ Input::old('address', $settings->address) }}</textarea>
                                {!! $errors->first('address', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!-- ********************************** -->
                    <!--       Additional Footer Text       -->
                    <!-- ********************************** -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('additional_footer_text') ? 'has-error' : '' }}">
                            <label for="additional_footer_text"
                                   class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.additional_footer_text') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'additional_footer_text')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="additional_footer_text" name="footer_text"
                                                  id="additional_footer_text" cols="30" rows="10"
                                                  class="form-control col-md-7 col-xs-12">{{ Input::old('additional_footer_text', $settings->bank_account_no) }}</textarea>
                                {!! $errors->first('additional_footer_text', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                </div><!-- .row -->

            </div><!-- .box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-4 col-md-offset-3">
                        <button class="btn btn-lg btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
                        </button>
                    </div><!-- col-md-4 col-md-offset-6 -->
                </div><!-- .row -->
            </div><!-- box-footer -->
        </form><!-- form-horizontal form-label-left -->
    </div><!-- box box-primary -->
@endsection