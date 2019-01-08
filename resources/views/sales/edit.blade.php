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
                <form action="{{ ($sale) ? route('sales.update', ['sale'=> $sale->id]) : route('sales.store') }}" autocomplete="off" role="form" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="box">

                            <!-- ********************** -->
                            <!--        Sales Input     -->
                            <!-- ********************** -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="seller" value="{{ Auth::user()->fullName }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ********************** -->
                            <!--        Sales ID     -->
                            <!-- ********************** -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control" id="sales_code" name="sales_code" value="{{ $sale->code }}"
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
                            <div class="form-group row add-product">
                                <div class="col-xs-6" style="padding-right: 0px;">
                                    <div class="input-group">
                                        <span class="input-group-addon"><button class="btn btn-danger btn-xs"
                                                                                type="button"><i
                                                        class="fa fa-times"></i></button></span>
                                        <input type="text" class="form-control" placeholder="Product name" readonly>
                                    </div><!-- input-group -->
                                </div><!-- col-xs-6 -->

                                <!-- Product quantity -->
                                <div class="col-xs-3">
                                    <input type="number" class="form-control" min="1" placeholder="0" required>
                                </div><!-- col-xs-3 -->

                                <!-- Total price -->
                                <div class="col-xs-3" style="padding-left: 0px">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion ion-logo-usd"></i></span>
                                        <input type="number" min="1" class="form-control" required readonly>
                                    </div><!-- input-group -->
                                </div><!-- col-xs-3 -->
                            </div><!-- form-group -->

                            <!-- hidden button to show only on small screen -->
                            <button class="btn btn-default hidden-lg" type="button">Add Product</button>

                            <hr>

                            <div class="row">
                                <div class="col-xs-8 pull-right">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Tax</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td style="width: 50%">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" min="0" placeholder="0"
                                                           required>
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                </div><!-- input-group -->
                                            </td>

                                            <td style="width: 50%">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="ion ion-logo-usd"></i></span>
                                                    <input type="number" class="form-control" min="1"
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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><img src="{{ asset('images/products_placeholder.png') }}" class="img-thumbnail" width="40px" alt=""></td>
                                <td>0123</td>
                                <td>iPhone</td>
                                <td>20</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"class="btn btn-primary">Add</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
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
