@extends('layouts.default')
@section('title')
    @if($category->id)
        {{ __('categories/message.update_category') }}
    @else
        {{ __('categories/message.add_category') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('category.index') }}"><i class="fa fa-th"></i> {{ __('general.categories')  }}</a></li>
    @if($category->id)
        <li class="active">{{ __('general.update_category') }}</li>
    @else
        <li class="active">{{ __('general.add_category') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="post" autocomplete="off"
                  action="{{ ($category) ? route('category.update', ['category'=> $category->id]) : route('category.store') }}"
                  class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                @if($category->id)
                    @method('PUT')
                @endif

                <div class="box-body">

                    <!--==========================
                     =            Image          =
                     ==========================-->

                    <div class="form-group">
                        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                            @if ($category->image)
                                <img src="{{ url('/') }}/uploads/categories/{{ $category->image }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 200px;"/>
                            @endif
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->

                    </div>


                    @include ('partials.forms.edit.image-upload')

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.name') }} {!! (\App\Helpers\Helper::checkIfRequired($category, 'name')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.name') }}"
                                   value="{{ Input::old('name', $category->name) }}">
                            {!! $errors->first('name', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-6">
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
                            </button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

