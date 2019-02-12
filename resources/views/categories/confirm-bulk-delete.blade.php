@extends('layouts.default')
@section('title')
    {{ __('general.bulk_checkin_and_delete') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('categories.index') }}"><i class="fa fa-th"></i> {{ __('general.categories') }}</a></li>
    <li class="active">{{ __('general.bulk_checkin_and_delete') }}</li>
@endsection

@section('content')
    <div class="box box-danger">
        <form action="{{ route('categories.bulkSave') }}" class="form-horizontal" method="POST" id="bulkForm">
            <div class="box-body">

                @csrf
                <div class="callout callout-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>{{ __('general.warning') }}: </strong>
                    {{ __('categories/message.bulk_delete_warning', ['count' => count($categories) ]) }}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>{{ __('general.name') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="{{ $category->id }}" checked>
                                        </td>
                                        <td>
                                            {{ $category->name }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- col-md-12 -->
                </div><!-- .row -->
            </div><!-- box-body -->
            <div class="box-footer text-right">
                <a class="btn btn-link" href="{{ URL::previous() }}">{{ __('general.cancel') }}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.submit') }}</button>
            </div><!-- box-footer text-right -->
        </form>
    </div><!-- .box -->
@endsection
