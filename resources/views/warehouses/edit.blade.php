@extends('layouts.default')
@section('title')
    @if($warehouse->id)
        {{ __('warehouses/message.update_warehouse') }}
    @else
        {{ __('warehouses/message.add_warehouse') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('warehouses.index') }}"><i class="fa fa-th"></i> {{ __('general.warehouses')  }}</a></li>
    @if($warehouse->id)
        <li class="active">{{ __('general.update_warehouse') }}</li>
    @else
        <li class="active">{{ __('general.add_warehouse') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="post" autocomplete="off"
                  action="{{ ($warehouse) ? route('warehouses.update', ['warehouse'=> $warehouse->id]) : route('warehouses.store') }}"
                  class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                @if($warehouse->id)
                    @method('PUT')
                @endif

                <div class="box-body">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.code') }} {!! (\App\Helpers\Helper::checkIfRequired($warehouse, 'code')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="code" name="code" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.code') }}"
                                   value="{{ Input::old('code', $warehouse->code) }}">
                            {!! $errors->first('code', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.name') }} {!! (\App\Helpers\Helper::checkIfRequired($warehouse, 'name')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.name') }}"
                                   value="{{ Input::old('name', $warehouse->name) }}">
                            {!! $errors->first('name', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.email') }} {!! (\App\Helpers\Helper::checkIfRequired($warehouse, 'email')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="email" name="email" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.email') }}"
                                   value="{{ Input::old('email', $warehouse->email) }}">
                            {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.phone') }} {!! (\App\Helpers\Helper::checkIfRequired($warehouse, 'phone')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="phone" name="phone" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.phone') }}"
                                   value="{{ Input::old('phone', $warehouse->phone) }}">
                            {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-3">
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
                            </button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

