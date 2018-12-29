@extends('layouts.default')
@section('title')
    {{ __('general.settings') }}
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.settings') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('settings.branding') }}" class="black-text">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-copyright"></i></span>
                    <div class="info-box-content">
                        <h4><string>{{ __('general.branding') }}</string></h4>
                        <small>{{ __('general.logo') }}, {{ __('general.site_name') }}, {{ __('general.etc') }}</small>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>

        <!-- *********************-->
        <!--     Localization     -->
        <!-- *********************-->

        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ route('settings.localization') }}" class="black-text">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-globe"></i></span>
                    <div class="info-box-content">
                        <h4><string>{{ __('general.localization') }}</string></h4>
                        <small>{{ __('general.language') }}, {{ __('general.date') }}, {{ __('general.etc') }}</small>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
    </div><!-- .row -->
@endsection

