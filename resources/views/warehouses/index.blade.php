@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.warehouses') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.warehouses') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">

                @can('warehouse.add')
                    <a href="{{ route('warehouses.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ __('general.create_new') }}</a>
                @endcan

                @can('warehouse.view')
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('warehouses.index') }}" class="btn btn-default"><i class="fa fa-building"></i> {{ __('general.show_current_warehouses') }}</a>
                    @else
                        <a href="{{ route('warehouses.index', ['status' => 'deleted']) }}" class="btn btn-default"><i class="fa fa-trash"></i> {{ __('general.show_deleted_warehouses') }}</a>
                    @endif
                @endcan

                @can('warehouse.export')
                    <a href="{{ route('warehouses.csv.export') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ __('general.export') }}</a>
                @endcan


            </div><!-- pull-right -->
        </div>
        <div class="box-body">
            <form action="{{ route('warehouses.bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @csrf
                @if(Input::get('status') != 'deleted')

                    @can('warehouses.bulk_delete')

                        <div id="toolbar">
                            <select name="bulk_actions" class="form-control select2" width="200px;">
                                <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                            </select>
                            <button class="btn btn-default" id="bulkEdit" disabled>{{ __('general.go') }}</button>

                        </div> <!-- #toolbar -->
                    @endif
                @endcan

                @can('warehouse.view')
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\WarehousePresenter::dataTableLayout() }}"
                            data-cookie-id-table="warehousesTable"
                            data-pagination="true"
                            data-id-table="warehousesTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="warehousesTable"
                            class="table table-striped milypos-table warehouses-table"
                            data-url="{{
                            route('warehouses.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                            data-export-options='{
                            "fileName": "export-warehouses-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                            }'>

                    </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('warehouses/message.do_not_have_permission_to_see_warehouse_list') }}</h5>
                    </div>
                @endcan
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')
@endsection