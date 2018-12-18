@extends('layouts.default')
@section('title')
    {{ __('general.bulk_checkin_and_delete') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> {{ __('general.users') }}</a></li>
    <li class="active">{{ __('general.bulk_checkin_and_delete') }}</li>
@endsection

@section('content')
    <div class="box box-danger">
        <form action="{{ route('users.bulkSave') }}" class="form-horizontal" method="POST" id="bulkForm">
            <div class="box-body">

                @csrf
                <div class="callout callout-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>{{ __('general.warning') }}: </strong>
                    {{ __('users/message.bulk_delete_warning', ['count' => count($users) ]) }}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>{{ __('general.name') }}</th>
                                    <th>{{ __('general.email') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr {!! ($user->hasRole('Super Admin') ? ' class="danger"':'') !!}>
                                        <td>
                                            @if(Auth::user()->id != $user->id)
                                                <input type="checkbox" name="ids[]" value="{{ $user->id }}"
                                                       checked="checked">
                                            @else
                                                <input type="checkbox" name="ids[]" value="{{ $user->id }}" disabled>
                                            @endif
                                        </td>

                                        <td>
                                            <span {!! ((Auth::user()->id == $user->id) ? ' style="text-decoration: line-through"' : '') !!}> {{ $user->fullName }} </span> {{ (Auth::user()->id==$user->id ? ' ('.strtolower(__('cannot delete yourself')).')' : '') }}
                                        </td>

                                        <td>
                                            <span {!! ((Auth::user()->id == $user->id) ? ' style="text-decoration: line-through"' : '') !!}> {{ $user->email }} </span> {{ (Auth::user()->id==$user->id ? ' ('.strtolower(__('cannot delete yourself')).')' : '') }}
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

@section('page_scripts')
    @include ('layouts.partials.bootstrap-table')
@endsection