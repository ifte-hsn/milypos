@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.roles') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.roles') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">

                @can('Create Roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ __('general.create_new') }}</a>
                @endcan

                @can('Read Roles')
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('roles.index') }}" class="btn btn-default"><i class="fa fa-shield"></i> {{ __('general.show_current_roles') }}</a>
                    @else
                        <a href="{{ route('roles.index', ['status' => 'deleted']) }}" class="btn btn-default"><i class="fa fa-trash"></i> {{ __('general.show_deleted_roles') }}</a>
                    @endif
                    <a href="{{ route('category.csv.export') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ __('general.export') }}</a>
                @endcan


            </div><!-- pull-right -->
        </div>
        <div class="box-body">
                @can('Read Role')
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\RolePresenter::dataTableLayout() }}"
                            data-cookie-id-table="rolesTable"
                            data-pagination="true"
                            data-id-table="rolesTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="rolesTable"
                            class="table table-striped milypos-table roles-table"
                            data-url="{{
                            route('roles.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                            data-export-options='{
                            "fileName": "export-roles-{{ date('Y-m-d') }}"
                            }'>

                    </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('roles/message.do_not_have_permission_to_see_roles_list') }}</h5>
                    </div>
                @endcan
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')
@endsection