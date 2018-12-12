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
            <form method="post" autocomplete="off" action="{{ ($user) ? route('users.update', ['user'=> $user->id]) : route('users.store') }}" class="form-horizontal form-label-left" id="user-form">
                @csrf

                @if($user->id)
                    @method('PUT')
                @endif

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">

                            <!--==========================
                            =            Logo            =
                            ===========================-->
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <img src="https://picsum.photos/200/200" alt="..." class="img-thumbnail">
                                </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            </div><!-- form-group -->
                            <div class="form-group">
                                <label for="avatar" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    Avatar
                                </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="avatar" name="avatar" type="file" class="form-control col-md-7 col-xs-12">
                                </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                            </div><!-- form-group -->



                        </div><!-- .col-md-4 -->

                        <!-- ************ SETTING FIELDS  ***********-->
                        <div class="col-md-8 col-xs-12">
                            <div class="row">

                                <!--================================
                                =            First Name            =
                                =================================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                        <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.first_name') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="first_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.first_name') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--================================
                                =            Last Name            =
                                =================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                        <label for="last-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.last_name') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="last-name" name="last_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.last_name') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--=================================
                                =            Email Address          =
                                ==================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('email_address') ? 'has-error' : '' }}">
                                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.email_address') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.email_address') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--============================
                                =            Password         =
                                ============================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.password') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.password') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--============================
                                =            Password         =
                                ============================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                                        <label for="confirm-password" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.confirm_password') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" id="confirm-password" name="confirm_password" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.confirm_password') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--=======================
                                =            Role         =
                                ========================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                                        <label for="role" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.role') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="role" id="role" class="form-control select2">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--==================================
                                =            Employee Number         =
                                ===================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                                        <label for="employee-num" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.employee_num') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="employee-num" name="employee_num" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.employee_num') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--==========================
                                =            Website         =
                                ===========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                                        <label for="website" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.website') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="website" name="website" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.website') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--========================
                                =            Phone         =
                                =========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.phone') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.phone') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--======================
                                =            Fax         =
                                =======================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('fax') ? 'has-error' : '' }}">
                                        <label for="fax" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.fax') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="fax" name="fax" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.fax') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--==========================
                                =            Address         =
                                ===========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.address') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7 col-xs-12"></textarea>
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            City         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                        <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.city') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="city" name="city" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.city') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--========================
                                =            State         =
                                =========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                                        <label for="state" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.state') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="state" name="state" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.state') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Zip         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                                        <label for="zip" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.zip') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="zip" name="zip" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.zip') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Country         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                        <label for="country" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.country') }}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="country" name="country" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.country') }}">
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!-- ********************* -->
                                <!--          Active       -->
                                <!-- ********************* -->
                                <div class="form-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="role" class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.status') }}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->

                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="activated" value="1" checked="checked" id="status">
                                            Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="activated" value="0" id="status">
                                            Inactive
                                        </label>
                                    </div>
                                </div>

                            </div><!-- .row -->
                        </div><!-- col-md-8 col-xs-12 -->

                    </div><!-- .row -->
                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-6">
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}</button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

