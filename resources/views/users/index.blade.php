@extends('layouts.default')

@section('title')
    @if (Input::get('status') == 'deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.users') }}
@endsection


@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.users') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <form method="POST" action="{{ url('users/bulkedit') }}" class="form-inline" id="bulkForm">
                        @csrf
                        @if(Input::get('status') != 'deleted')
                            <div class="toolbar">
                                <select name="bulk_action" class="form-control select2" style="width: 200px;">
                                    <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                                    <option value="edit">{{ __('bulk_edit') }}</option>
                                </select>
                                <button class="btn btn-default" id="bulkEdit" disabled>{{ __('general.go') }}</button>
                            </div><!-- toolbar -->
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Iftekhar hossain</td>
                                    <td>ifte.hsn@gmail.com</td>
                                    <td>234567</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div><!-- box-body -->
            </div><!-- box box-default -->
        </div><!-- col-md-12 -->
    </div><!-- .row -->
@endsection