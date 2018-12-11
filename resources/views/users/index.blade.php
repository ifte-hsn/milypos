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
        <div class="box-header with-border clearfix">
            <div class="pull-right">
                @can('Export Users List')
                    <a href="{{ route('users.export') }}" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
                @endcan

                @can('See Deleted Users')
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fa fa-user-circle"></i> Show Current Users</a>
                    @else
                        <a href="{{ route('users.index', ['status' => 'deleted']) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Show Deleted Users</a>
                    @endif
                @endcan

                @can('Create User')
                    <a href="#" class="btn btn-info"><i class="fa fa-plus"></i> Create New</a>
                @endcan

            </div><!-- pull-right -->
        </div>
        <div class="box-body">
            <form action="{{ url('users/bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @if(Input::get('status') != 'deleted')
                    @if(auth()->user()->can('Delete User') || auth()->user()->can('Update User'))
                        <div id="toolbar">
                            <select name="bulk_actions" class="form-control select2" width="200px;">
                                @can('Delete User')
                                    <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                                @endcan

                                @can('Update User')
                                    <option value="edit">{{ __('general.bulk_edit') }}</option>
                                @endcan
                            </select>
                            <button class="btn btn-default" id="bulkEdit" disabled>Go</button>

                        </div> <!-- #toolbar -->
                    @endif
                @endif

                @can('Read Users List')
                <table
                        data-click-to-select="true"
                        data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                        data-cookie-id-table="usersTable"
                        data-pagination="true"
                        data-id-table="usersTable"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        @can('Export Users List')
                        data-show-export="true"
                        @endcan
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
                @endcan
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('layouts.partials.bootstrap-table')
@endsection