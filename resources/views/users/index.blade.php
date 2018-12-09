@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ trans('general.deleted') }}
    @else
        {{ trans('general.current') }}
    @endif
    {{ trans('general.users') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form action="{{ url('users/bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @if(Input::get('status') != 'deleted')
                    <div id="toolbar">

                        <select name="bulk_actions" class="form-control select2" width="200px;">
                            <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                            <option value="edit">{{ __('general.bulk_edit') }}</option>
                        </select>
                        <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                    </div> <!-- #toolbar -->
                @endif

                <table
                        data-click-to-select="true"
                        data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                        data-cookie-id-table="usersTable"
                        data-pagination="true"
                        data-id-table="usersTable"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-toolbar="#toolbar"
                        id="usersTable"
                        class="table table-striped milypos-table"
                        data-url="{{
                            route('api.users.index',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                        data-export-options='{
                            "fileName": "export-users-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                            }'>

                </table>
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('layouts.partials.bootstrap-table')
@endsection