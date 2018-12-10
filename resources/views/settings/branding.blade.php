@extends('layouts.default')
@section('title')
    {{ __('settings/general.general_settings') }}
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('settings.general.index') }}"><i class="fa fa-wrench"></i>Settings</a></li>
    <li class="active">{{ __('settings/general.general_settings') }}</li>
@endsection

@section('content')

    <div class="box box-primary">
        <form action="" class="form-horizontal form-label-left">
            <div class="box-header with-border">
                <h3 class="box-title">Branding</h3>
            </div><!-- box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <!-- *********************** -->
                        <!--       LOGO      -->
                        <!-- *********************** -->
                        <div class="form-group">
                            <label for=""
                                   class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('settings/general.logo') }}</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <img src="https://picsum.photos/200/50" alt="..." class="img-thumbnail">
                            </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            <div class="col-md-9 col-md-offset-3">
                                <input type="file">
                            </div>
                        </div><!-- form-group -->


                        <!-- FAVICON -->
                        <div class="form-group">
                            <label for=""
                                   class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.favicon') }}</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <img src="https://picsum.photos/28/28" alt="..." class="img-thumbnail">
                            </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            <div class="col-md-9 col-md-offset-3">
                                <input type="file">
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Company Name
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- *********************** -->
                            <!--       Site name          -->
                            <!-- ************************ -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Site Name
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--       Company email          -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Company Email
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Phone         -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Phone
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--             Fax               -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Fax
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--              Website              -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Website
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--             VAT No            -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        VAT No
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Bank Account No         -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Bank Account No
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Header color          -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Header Color
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12">
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                            <!-- ***************************** -->
                            <!--       Custom CSS        -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Custom CSS
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="" id="" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
                                    </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                </div><!-- form-group -->
                            </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                            <!-- ***************************** -->
                            <!--       Custom CSS        -->
                            <!-- **************************** -->

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        Additional Footer Text
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="" id="" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
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

