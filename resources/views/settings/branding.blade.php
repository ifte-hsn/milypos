@extends('layouts.default')
@section('title')
    {{ __('general.general_settings') }}
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('settings.general.index') }}"><i class="fa fa-wrench"></i>Settings</a></li>
    <li class="active">{{ __('general.general_settings') }}</li>
@endsection

@section('content')

    <div class="box box-primary">
        <form action="" class="form-horizontal form-label-left">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('general.branding') }}</h3>
            </div><!-- box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <!-- *********************** -->
                        <!--       LOGO      -->
                        <!-- *********************** -->
                        <div class="form-group">
                            <label for="logo"
                                   class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.logo') }}</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <img src="https://picsum.photos/200/50" alt="{{ ($milyPosSettings->site_name) ? $milyPosSettings->site_name : '' }}" class="img-thumbnail">
                            </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            <div class="col-md-9 col-md-offset-3">
                                <input id="logo" type="file" class="form-control">
                            </div>
                        </div><!-- form-group -->


                        <!-- FAVICON -->
                        <div class="form-group">
                            <label for="favicon"
                                   class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.favicon') }}</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <img src="https://picsum.photos/28/28" alt="..." class="img-thumbnail">
                            </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            <div class="col-md-9 col-md-offset-3">
                                <input id="favicon" type="file" class="form-control">
                            </div>
                        </div><!-- form-group -->

                    </div><!-- .col-md-4 -->

                    <!-- ************ SETTING FIELDS  ***********-->
                    <div class="col-md-8 col-xs-12">
                        <div class="row">

                            <!-- *********************** -->
                            <!--       Company name      -->
                            <!-- ************************ -->


                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="company_name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.company_name') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="company_name" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.company_name') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- *********************** -->
                            <!--       Site name          -->
                            <!-- ************************ -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="site_name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.site_name') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="site_name" type="text" class="form-control col-md-7 col-xs-12" placeholder=" {{ __('general.site_name') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--       Company email          -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="company_email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.company_email') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="company_email" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.company_email') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Phone         -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.phone') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="phone" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.phone') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--             Fax               -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="fax" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.fax') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="fax" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.fax') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--              Website              -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="website" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.website') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="website" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.website') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--             VAT No            -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="vat_no" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.vat_no') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="vat_no" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.vat_no') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Bank Account No         -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="bank_account_no" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.bank_account_no') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="bank_account_no" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.bank_account_no') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->



                            <!-- ***************************** -->
                            <!--       Address        -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.address') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Header color          -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="header_color" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.header_color') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="header_color" type="text" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.header_color') }}">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--       Custom CSS        -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="custom_css" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.custom_css') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="" id="custom_css" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ********************************** -->
                            <!--       Additional Footer Text       -->
                            <!-- ********************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="additional_footer_text" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.additional_footer_text') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="additional_footer_text" id="additional_footer_text" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                        </div><!-- .row -->
                    </div><!-- col-md-8 col-xs-12 -->

                </div><!-- .row -->
            </div><!-- .box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-4 col-md-offset-6">
                        <button class="btn btn-success"><i class="fa fa-floppy-o"></i> Update Sattings</button>
                    </div><!-- col-md-4 col-md-offset-6 -->
                </div><!-- .row -->
            </div><!-- box-footer -->
        </form><!-- form-horizontal form-label-left -->
    </div><!-- box box-primary -->
@endsection

