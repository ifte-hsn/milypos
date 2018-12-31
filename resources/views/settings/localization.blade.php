@extends('layouts.default')
@section('title')
    {{ __('general.localization') }} {{ __('general.settings') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active"><a href="{{ route('settings.index') }}"><i class="fa fa-wrench"></i> {{ __('general.settings') }}</a></li>
    <li class="active">{{ __('general.localization') }}</li>
@endsection

@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>
    <div class="box box-primary">
        <form action="{{ route('settings.localization') }}" method="post" class="form-horizontal form-label-left">
            @csrf
            <div class="box-body">
                <div class="margin-top"></div>
                <div class="row">

                    <!--==========================
                     =          Language         =
                     ==========================-->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
                            <label for="locale" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.language') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'locale')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select name="locale" id="locale" class="form-control select2">
                                    <option value="">{{ __('general.select') }}</option>
                                    <option value="en" {!!  ($settings->locale === 'en') ? 'selected="selected"':'' !!}>English, US</option>
                                    <option value="en-GB" {!!  ($settings->locale === 'en-GB') ? 'selected="selected"':'' !!}>English, UK</option>
                                    <option value="bn" {!!  ($settings->locale === 'bn') ? 'selected="selected"':'' !!}>Bangla</option>
                                </select>
                                {!! $errors->first('local', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!--==========================
                    =       Date Format         =
                    ==========================-->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('date_display_format') ? 'has-error' : '' }}">
                            <label for="date_display_format" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.date_display_format') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'date_display_format')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select name="date_display_format" id="date_display_format" class="form-control select2">
                                    <option value="">{{ __('general.select') }}</option>
                                    <option value="Y-m-d" {!!  ($settings->date_display_format === 'Y-m-d') ? 'selected="selected"':'' !!}>{!! date('Y-m-d') !!}</option>
                                    <option value="D M d, Y" {!!  ($settings->date_display_format === 'D M d, Y') ? 'selected="selected"':'' !!}>{!! date('D M d, Y') !!}</option>
                                    <option value="M j, Y" {!!  ($settings->date_display_format === 'M j, Y') ? 'selected="selected"':'' !!}>{!! date('M j, Y') !!}</option>
                                    <option value="d M, Y" {!!  ($settings->date_display_format === 'd M, Y') ? 'selected="selected"':'' !!}>{!! date('d M, Y') !!}</option>
                                    <option value="m/d/Y" {!!  ($settings->date_display_format === 'm/d/Y') ? 'selected="selected"':'' !!}>{!! date('m/d/Y') !!}</option>
                                    <option value="n/d/y" {!!  ($settings->date_display_format === 'n/d/y') ? 'selected="selected"':'' !!}>{!! date('n/d/y') !!}</option>
                                    <option value="d/m/Y" {!!  ($settings->date_display_format === 'd/m/Y') ? 'selected="selected"':'' !!}>{!! date('d/m/Y') !!}</option>
                                    <option value="m/j/Y" {!!  ($settings->date_display_format === 'm/j/Y') ? 'selected="selected"':'' !!}>{!! date('m/j/Y') !!}</option>
                                    <option value="d.m.Y" {!!  ($settings->date_display_format === 'd.m.Y') ? 'selected="selected"':'' !!}>{!! date('d.m.Y') !!}</option>
                                </select>
                                {!! $errors->first('date_display_format', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!--==========================
                    =        Time Format         =
                    ==========================-->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('time_display_format') ? 'has-error' : '' }}">
                            <label for="time_display_format" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.time_display_format') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'time_display_format')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select name="time_display_format" id="time_display_format" class="form-control select2">
                                    <option value="">{{ __('general.select') }}</option>
                                    <option value="g:i A" {!!  ($settings->time_display_format === 'g:i A') ? 'selected="selected"':'' !!}>{!! date('g:i A') !!}</option>
                                    <option value="h:i A" {!!  ($settings->time_display_format === 'h:i A') ? 'selected="selected"':'' !!}>{!! date('h:i A') !!}</option>
                                    <option value="H:i" {!!  ($settings->time_display_format === 'H:i') ? 'selected="selected"':'' !!}>{!! date('H:i') !!} (24 hour clock)</option>
                                </select>
                                {!! $errors->first('time_display_format', '<span class="alert-msg">:message</span>') !!}
                            </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                        </div><!-- form-group -->
                    </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                    <!--=============================
                    =        Default Currency       =
                    ==============================-->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('default_currency') ? 'has-error' : '' }}">
                            <label for="default_currency" class="control-label col-md-3 col-sm-3 col-xs-12">
                                {{ __('general.default_currency') }} {!! (\App\Helpers\Helper::checkIfRequired($settings, 'default_currency')) ? '<span class="text-danger">*</span>':'' !!}
                            </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select name="currency_id" id="default_currency" class="form-control select2">
                                    <option value="">{{ __('general.select') }}</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {!!  ($settings->currency->id === $currency->id) ? 'selected="selected"':'' !!}>{{ $currency->country. ' '.$currency->currency .' ('.$currency->code.')'}}</option>
                                    @endforeach

                                    </select>
                                {!! $errors->first('currency_id', '<span class="alert-msg">:message</span>') !!}
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