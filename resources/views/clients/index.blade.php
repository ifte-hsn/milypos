@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.clients') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.clients') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">

                @can('add_client')
                    <a href="{{ route('clients.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ __('general.create_new') }}</a>
                @endcan

                @can('view_client')
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('clients.index') }}" class="btn btn-default"><i class="fa fa-user-circle"></i> {{ __('general.show_current_clients') }}</a>
                    @else
                        <a href="{{ route('clients.index', ['status' => 'deleted']) }}" class="btn btn-default"><i class="fa fa-trash"></i> {{ __('general.show_deleted_clients') }}</a>
                    @endif
                @endcan

                @can('export_clients')
                    <a href="{{ route('clients.csv.export') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ __('general.export') }}</a>
                @endcan


            </div><!-- pull-right -->
        </div>
        <div class="box-body">
            <form action="{{ route('clients.bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @csrf
                @if(Input::get('status') != 'deleted')

                    @can('bulk_delete_clients')

                        <div id="toolbar">
                            <select name="bulk_actions" class="form-control select2" width="200px;">
                                @can('bulk_delete_clients')
                                    <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                                @endcan
                            </select>
                            <button class="btn btn-default" id="bulkEdit" disabled>Go</button>

                        </div> <!-- #toolbar -->
                    @endif
                @endcan

                @can('view_client')
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\ClientPresenter::dataTableLayout() }}"
                            data-cookie-id-table="clientsTable"
                            data-pagination="true"
                            data-id-table="clientsTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="clientsTable"
                            class="table table-striped milypos-table clients-table"
                            data-url="{{
                            route('clients.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                            data-export-options='{
                            "fileName": "export-clients-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                            }'>

                    </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('clients/message.do_not_have_permission_to_see_client_list') }}</h5>
                    </div>
                @endcan
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')
@endsection