@extends('layouts.default')
@section('title')
    {{ __('general.current') }} {{ __('general.sales') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.sales') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">

                @can('add_sale')
                    <a href="{{ route('sales.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ __('general.create_new') }}</a>
                @endcan

                @can('export_sales')
                    <a href="{{ route('sales.csv.export') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ __('general.export') }}</a>
                @endcan


            </div><!-- pull-right -->
        </div>
        <div class="box-body">

                @can('view_sale')
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\SalePresenter::dataTableLayout() }}"
                            data-cookie-id-table="salesTable"
                            data-pagination="true"
                            data-id-table="salesTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="salesTable"
                            class="table table-striped milypos-table sales-table"
                            data-url="{{
                            route('sales.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                            data-export-options='{
                            "fileName": "export-sales-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                            }'>

                    </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('sales/message.do_not_have_permission_to_see_sale_list') }}</h5>
                    </div>
                @endcan

        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')
@endsection