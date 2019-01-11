@extends('layouts.default')
@section('title')
    @if($sale->id)
        {{ __('sales/message.update_sale') }}
    @else
        {{ __('sales/message.add_sale') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('sales.manage') }}"><i class="fa fa-th"></i> {{ __('general.manage_sales')  }}</a></li>
    @if($sale->id)
        <li class="active">{{ __('general.update_sale') }}</li>
    @else
        <li class="active">{{ __('general.create_sale') }}</li>
    @endif

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border"></div><!-- box-header -->
                <form action="{{ ($sale) ? route('sales.update', ['sale'=> $sale->id]) : route('sales.store') }}"
                      autocomplete="off" role="form" method="post" class="sales-form">
                    @csrf
                    <div class="box-body">
                        <div class="box">

                            <!-- ********************** -->
                            <!--        Sales Input     -->
                            <!-- ********************** -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="seller"
                                           value="{{ Auth::user()->fullName }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ********************** -->
                            <!--        Sales ID     -->
                            <!-- ********************** -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control" id="sales_code" name="sales_code"
                                           value="{{ $sale->code }}"
                                           readonly>
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ***************** -->
                            <!--        Client     -->
                            <!-- ***************** -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                    <select name="client_id" id="client_id" class="form-control select2">
                                        <option value="">{{ __('general.select') }}</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ $client->id == $sale->client_id ? 'selected="selected"' : '""' }}>{{ $client->fullName }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs"
                                                                            data-toggle="modal"
                                                                            data-target="#modalAddClient">Add Client</button></span>
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ******************************* -->
                            <!--    Entry for adding product     -->
                            <!-- ******************************* -->
                            <table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('general.products') }}</th>
                                        <th>{{ __('general.quantity') }}</th>
                                        <th>{{ __('general.price') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><button class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>
                                        <td>iPhone</td>
                                        <td><input type="text" class="form-control" value="3"></td>
                                        <td><input type="text" class="form-control" value="1200"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <input type="hidden" id="products-list" name="products">

                            <!-- hidden button to show only on small screen -->
                            <button class="btn btn-default hidden-lg" type="button" id="add-product">Add Product</button>

                            <hr>

                            <div class="row">
                                <div class="col-xs-12 pull-right">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Tax</th>
                                            <th>Sub Total</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td style="width: 25%">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="tax" name="tax"
                                                           min="0" placeholder="0"
                                                           required>
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div><!-- input-group -->
                                            </td>

                                            <td style="width: 35%">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="ion ion-logo-usd"></i></span>
                                                    <input type="number" class="form-control sub-total" id="sub-total"
                                                           name="sub_total" min="1"
                                                           placeholder="00000" required readonly="">
                                                </div><!-- input-group -->
                                            </td>

                                            <td style="width: 40%">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="ion ion-logo-usd"></i></span>
                                                    <input type="number" class="form-control total" id="total"
                                                           name="total" min="1"
                                                           placeholder="00000" required readonly="">
                                                </div><!-- input-group -->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--  col-xs-8 -->
                            </div><!-- row  -->

                            <hr>

                            <!-- ******************* -->
                            <!--    Payment Method   -->
                            <!-- ******************* -->
                            <div class="form-group row">

                                <div class="col-xs-6">
                                    <select name="payment_method" id="payment_method" class="form-control select2">
                                        <option value="">Select Payment Method</option>
                                        <option value="">Cash</option>
                                        <option value="">Credit Card</option>
                                        <option value="">Debit Card</option>
                                    </select>
                                </div><!-- col-xs-6 -->

                                <div class="col-xs-6" style="padding-left: 0px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control" required>
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div><!-- col-xs-6 -->

                            </div><!-- form-group row -->

                            <br>
                        </div><!-- box -->
                    </div><!-- box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-left">Go Out</button>
                        <button type="button" class="btn btn-primary pull-right">Save Sale</button>
                    </div><!-- .box-footer -->
                </form>
            </div><!-- box box-success -->
        </div><!-- col-lg-5 col-xs-12

        <!--**************************-->
        <!--    List Of Products      -->
        <!--**************************-->
        <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
            <div class="box box-warning">
                <div class="box-header with-border"></div><!-- box-header -->
                <div class="box-body">

                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\ProductPresenter::dataTableLayoutForSale() }}"
                            data-cookie-id-table="salesTable"
                            data-pagination="true"
                            data-id-table="salesTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="false"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="salesTable"
                            class="table table-bordered table-striped milypos-table products-table"
                            data-url="{{ route('products.list')  }}">

                    </table>

                </div><!-- .box-body -->
            </div><!-- box -->
        </div><!-- col-lg-7 -->
    </div><!-- .row -->



    <!-- Modal -->
    <div class="modal fade" id="modalAddClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    @include ('partials.bootstrap-table')


    <script>

    </script>
@endsection
