@extends('layouts.default')
@section('title')
    @if($user->id)
        {{ __('general.update_user') }}
    @else
        {{ __('general.add_user') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> {{ __('general.users')  }}</a></li>
    @if($user->id)
        <li class="active">{{ __('general.update_user') }}</li>
    @else
        <li class="active">{{ __('general.add_user') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form action="" class="form-horizontal form-label-left">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">

                            <!-- *********************** -->
                            <!--       LOGO      -->
                            <!-- *********************** -->
                            <div class="form-group">
                                <label for=""
                                       class="control-label col-md-3 col-sm-3 col-xs-12">{{ __('general.avatar') }}</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <img src="https://picsum.photos/200/200" alt="..." class="img-thumbnail">
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
        </div>
    </div><!-- box-primary -->
@endsection

