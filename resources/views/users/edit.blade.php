@extends('layouts.default')
@section('title')
    @if($user->id)
        {{ __('users/message.update_user') }}
    @else
        {{ __('users/message.add_user') }}
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
            <form method="post" autocomplete="off" action="{{ ($user) ? route('users.update', ['user'=> $user->id]) : route('users.store') }}" class="form-horizontal form-label-left" id="user-form" enctype="multipart/form-data">
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
                                    @if ($user->avatar)
                                        <img src="{{ url('/') }}/uploads/avatars/{{ $user->avatar }}" class="img-thumbnail">
                                    @else
                                        <img src="{{ url('/') }}/images/avatar-placeholder.png" class="img-thumbnail">
                                    @endif
                                </div><!-- col-md-9 col-sm-9 col-xs-12 -->
                            </div><!-- form-group -->
                            <div class="form-group">
                                <label for="uploadFile" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ __('general.avatar') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'avatar')) ? '<span class="text-danger">*</span>':'' !!}
                                </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="uploadFile" name="avatar" type="file" class="form-control col-md-7 col-xs-12">
                                    {!! $errors->first('avatar', '<span class="alert-msg">:message</span>') !!}
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
                                            {{ __('general.first_name') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'first_name')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="first_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.first_name') }}" value="{{ Input::old('first_name', $user->first_name) }}">
                                            {!! $errors->first('first_name', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--================================
                                =            Last Name            =
                                =================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                        <label for="last-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.last_name') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'last_name')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="last-name" name="last_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.last_name') }}" value="{{ Input::old('last_name', $user->last_name) }}">
                                            {!! $errors->first('last_name', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--=================================
                                =            Email Address          =
                                ==================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.email_address') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'email')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.email_address') }}" value="{{ Input::old('email', $user->email) }}">
                                            {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--============================
                                =            Password         =
                                ============================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.password') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'password')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @if($user->id)
                                                <button class="btn btn-link" onclick="$('#password').removeClass('hidden'); $(this).addClass('hidden')" type="button">Change Password</button>
                                            @endif
                                            <input type="password" id="password" name="password" class="form-control col-md-7 col-xs-12 {{ ($user->id) ? 'hidden' : '' }}" placeholder="{{ __('general.password') }}" value="">
                                            {!! $errors->first('password', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Sex          =
                                ========================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
                                        <label for="role" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.sex') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'sex')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="sex" id="sex" class="form-control select2">
                                                <option value="Male" {{ (isset($user->sex) && $user->sex === 'Male') ? 'selected="selected"':''  }}>{{ __('general.male') }}</option>
                                                <option value="Female" {{ (isset($user->sex) && $user->sex === 'Female') ? 'selected="selected"':''  }}>{{ __('general.female') }}</option>
                                            </select>
                                            {!! $errors->first('role', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--=======================
                                =            Role         =
                                ========================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                                        <label for="role" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.role') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'role')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="role" id="role" class="form-control select2">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected="selected"' : '""' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('role', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--==================================
                                =            Employee Number         =
                                ===================================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('employee_num') ? 'has-error' : '' }}">
                                        <label for="employee-num" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.employee_num') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'employee_num')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="employee-num" name="employee_num" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.employee_num') }}" value="{{ Input::old('employee_num', $user->employee_num) }}">
                                            {!! $errors->first('employee_num', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--==========================
                                =            Website         =
                                ===========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                                        <label for="website" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.website') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'website')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="website" name="website" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.website') }}" value="{{ Input::old('website', $user->website) }}">
                                            {!! $errors->first('website', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--========================
                                =            Phone         =
                                =========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.phone') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'phone')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.phone') }}" value="{{ Input::old('phone', $user->phone) }}">
                                            {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--======================
                                =            Fax         =
                                =======================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('fax') ? 'has-error' : '' }}">
                                        <label for="fax" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.fax') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'fax')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="fax" name="fax" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.fax') }}" value="{{ Input::old('fax', $user->fax) }}">
                                            {!! $errors->first('fax', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--==========================
                                =            Address         =
                                ===========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.address') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'address')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7 col-xs-12">{{ Input::old('address', $user->address) }}</textarea>
                                            {!! $errors->first('address', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            City         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                        <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.city') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'city')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="city" name="city" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.city') }}" value="{{ Input::old('city', $user->city) }}">
                                            {!! $errors->first('city', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--========================
                                =            State         =
                                =========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                                        <label for="state" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.state') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'state')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="state" name="state" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.state') }}" value="{{ Input::old('state', $user->state) }}">
                                            {!! $errors->first('state', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Zip         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                                        <label for="zip" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.zip') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'zip')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="zip" name="zip" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.zip') }}" value="{{ Input::old('zip', $user->zip) }}">
                                            {!! $errors->first('zip', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Country         =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                        <label for="country" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.country') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'country')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="country" id="country" class="form-control select2">
                                                <option value="">{{ __('general.select_country') }}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {!!  ($user->country_id == $country->id) ? 'selected="selected"':'' !!}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('country', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!-- ********************* -->
                                <!--          Active       -->
                                <!-- ********************* -->
                                <div class="form-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                        {{ __('general.status') }} {!! (\App\Helpers\Helper::checkIfRequired($user, 'activated')) ? '<span class="text-danger">*</span>':'' !!}
                                    </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->

                                    <div class="col-sm-9">
                                        <label class="radio-inline" for="active">
                                            <input type="radio" name="activated" value="1" checked="checked" id="active">
                                            {{ __('general.active') }}
                                        </label>
                                        <label for="inactive" class="radio-inline">
                                            <input type="radio" name="activated" value="0" id="inactive">
                                            {{ __('general.inactive') }}
                                            {!! $errors->first('status', '<span class="alert-msg">:message</span>') !!}
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

