@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.users') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.users') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">
                @can('Read User')
                    <a href="{{ url('users/export') }}" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fa fa-user-circle"></i> Show Current Users</a>
                    @else
                        <a href="{{ route('users.index', ['status' => 'deleted']) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Show Deleted Users</a>
                    @endif
                @endcan

                @can('Create User')
                    <a href="{{ route('users.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> Create New</a>
                @endcan

            </div><!-- pull-right -->
        </div>
        <div class="box-body">
            <form action="{{ route('users.bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @csrf
                @if(Input::get('status') != 'deleted')

                    @if(((Auth::user()->can('Delete User') || Auth::user()->can('Update User')) && Auth::user()->can('Read User')))

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
                    @endif {{-- Auth::user()->hasAnyPermission(['Update User', 'Delete User'])--}}
                @endif

                @can('Read User')
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
                        class="table table-striped milypos-table users-table"
                        data-url="{{
                            route('users.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                        data-export-options='{
                            "fileName": "export-users-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                            }'>

                </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('users/message.do_not_have_permission_to_see_user_list') }}</h5>
                    </div>
                @endcan
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('layouts.partials.bootstrap-table')
@endsection