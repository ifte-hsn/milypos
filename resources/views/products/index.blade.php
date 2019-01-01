@extends('layouts.default')
@section('title')
    @if (Input::get('status')=='deleted')
        {{ __('general.deleted') }}
    @else
        {{ __('general.current') }}
    @endif
    {{ __('general.products') }}
    @parent
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li class="active">{{ __('general.products') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border clearfix">
            <div class="pull-right">

                @can('add_product')
                    <a href="{{ route('products.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ __('general.create_new') }}</a>
                @endcan

                @can('view_product')
                    @if (Input::get('status')=='deleted')
                        <a href="{{ route('products.index') }}" class="btn btn-default"><i class="fa fa-th"></i> {{ __('general.show_current_products') }}</a>
                    @else
                        <a href="{{ route('products.index', ['status' => 'deleted']) }}" class="btn btn-default"><i class="fa fa-trash"></i> {{ __('general.show_deleted_products') }}</a>
                    @endif
                @endcan

                @can('export_products')
                    <a href="{{ route('products.csv.export') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ __('general.export') }}</a>
                @endcan

            </div><!-- pull-right -->
        </div>
        <div class="box-body">
            <form action="{{ route('products.bulkedit') }}" class="form-inline" method="POST" id="bulkForm">
                @csrf
                @if(Input::get('status') != 'deleted')

                    @if(((Auth::user()->can('delete_product') || Auth::user()->can('edit_product')) && Auth::user()->can('view_product')))

                        <div id="toolbar">
                            <select name="bulk_actions" class="form-control select2" width="200px;">
                                @can('delete_product')
                                    <option value="delete">{{ __('general.bulk_checkin_and_delete') }}</option>
                                @endcan
                            </select>

                            <button class="btn btn-default" id="bulkEdit" disabled>Go</button>

                        </div> <!-- #toolbar -->
                    @endif
                @endif

                @can('view_product')
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\ProductPresenter::dataTableLayout() }}"
                            data-cookie-id-table="productsTable"
                            data-pagination="true"
                            data-id-table="productsTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="productsTable"
                            class="table table-striped milypos-table products-table"
                            data-url="{{
                            route('products.list',
                                array(
                                    'deleted' => (Input::get('status')=='deleted'?'true':'false')))
                                }}"
                            data-export-options='{
                            "fileName": "export-products-{{ date('Y-m-d') }}"
                            }'>

                    </table>
                @else
                    <div class="alert alert-error">
                        <h5> <i class="fa fa-warning"></i> {{ __('products/message.do_not_have_permission_to_see_product_list') }}</h5>
                    </div>
                @endcan
            </form>
        </div><!-- box-body -->
    </div><!-- .box -->
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')
@endsection