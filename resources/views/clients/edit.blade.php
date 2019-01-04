@extends('layouts.default')
@section('title')
    @if($client->id)
        {{ __('clients/message.update_client') }}
    @else
        {{ __('clients/message.add_client') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('clients.index') }}"><i class="fa fa-user"></i> {{ __('general.clients')  }}</a></li>
    @if($client->id)
        <li class="active">{{ __('general.update_client') }}</li>
    @else
        <li class="active">{{ __('general.add_client') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="post" autocomplete="off" action="{{ ($client) ? route('clients.update', ['client'=> $client->id]) : route('clients.store') }}" class="form-horizontal form-label-left" id="client-form" enctype="multipart/form-data">
                @csrf
                @if($client->id)
                    @method('PUT')
                @endif

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">

                            <!--============================
                            =            Avatar            =
                            =============================-->


                            <div class="form-group">
                                <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                                    @if ($client->image)
                                        <img src="{{ url('/') }}/uploads/avatars/{{ $client->image }}" alt="{{ $client->name }}" class="img-thumbnail" style="max-width: 200px;"/>
                                    @endif
                                </div><!-- .col-md-6 col-sm-6 col-xs-12 -->

                            </div>


                            @include ('partials.forms.edit.image-upload')

                        </div><!-- .col-md-4 -->


                        <div class="col-md-8 col-xs-12">
                            <div class="row">

                                <!--================================
                                =            First Name            =
                                =================================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                        <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.first_name') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'first_name')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="first_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.first_name') }}" value="{{ Input::old('first_name', $client->first_name) }}">
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
                                            {{ __('general.last_name') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'last_name')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="last-name" name="last_name" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.last_name') }}" value="{{ Input::old('last_name', $client->last_name) }}">
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
                                            {{ __('general.email_address') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'email')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.email_address') }}" value="{{ Input::old('email', $client->email) }}">
                                            {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->



                                <!--=======================
                                =            Sex          =
                                ========================-->
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
                                        <label for="role" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.sex') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'sex')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="sex" id="sex" class="form-control select2">
                                                <option value="Male" {{ (isset($client->sex) && $client->sex === 'Male') ? 'selected="selected"':''  }}>{{ __('general.male') }}</option>
                                                <option value="Female" {{ (isset($client->sex) && $client->sex === 'Female') ? 'selected="selected"':''  }}>{{ __('general.female') }}</option>
                                            </select>
                                            {!! $errors->first('role', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->

                                <!--========================
                                =            Phone         =
                                =========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.phone') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'phone')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.phone') }}" value="{{ Input::old('phone', $client->phone) }}">
                                            {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--==========================
                                =            Address         =
                                ===========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.address') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'address')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7 col-xs-12">{{ Input::old('address', $client->address) }}</textarea>
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
                                            {{ __('general.city') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'city')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="city" name="city" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.city') }}" value="{{ Input::old('city', $client->city) }}">
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
                                            {{ __('general.state') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'state')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="state" name="state" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.state') }}" value="{{ Input::old('state', $client->state) }}">
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
                                            {{ __('general.zip') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'zip')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="zip" name="zip" class="form-control col-md-7 col-xs-12" placeholder="{{ __('general.zip') }}" value="{{ Input::old('zip', $client->zip) }}">
                                            {!! $errors->first('zip', '<span class="alert-msg">:message</span>') !!}
                                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                                    </div><!-- form-group -->
                                </div><!-- col-md-12 col-sm-12 col-xs-12 -->


                                <!--=======================
                                =            Country      =
                                ========================-->

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
                                        <label for="country" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            {{ __('general.country') }} {!! (\App\Helpers\Helper::checkIfRequired($client, 'country')) ? '<span class="text-danger">*</span>':'' !!}
                                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="country" id="country" class="form-control select2">
                                                <option value="">{{ __('general.select_country') }}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {!!  ($client->country_id == $country->id) ? 'selected="selected"':'' !!}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('country', '<span class="alert-msg">:message</span>') !!}
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
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}</button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

