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
                            <div class="form-group add-product" id="add-product">

                            </div><!-- form-group add-product-->
                            <input type="hidden" id="products-list" name="products">

                            <!-- hidden button to show only on small screen -->
                            <button class="btn btn-default hidden-lg" type="button">Add Product</button>

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
        $(document).ready(function () {
            $('.products-table').on('click', 'button.product-button', function () {
                $productId = $(this).data('product');
                $(this).removeClass('btn-primary product-button');
                $(this).addClass('btn-default');

                $.ajax({
                    url: "{{ route('sales.product_by_id') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: $productId
                    },
                    success: function (response) {

                        if (response.stock == 0) {
                            $('[data-product="' + response.id + '"]').removeClass('btn-default').addClass('btn-primary product-button');
                            alert('this product is out of stock');
                            return;
                        }
                        $('#add-product').append('<div class="row product-row product-' + response.id + '" style="padding: 5px 15px">' +
                            '<div class="col-xs-6" style="padding-right: 0px;">' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><button class="btn btn-danger btn-xs remove-product" type="button" data-product="' + response.id + '"><i class="fa fa-times"></i></button></span>' +
                            '<input type="text" class="form-control product-name" placeholder="Product name" data-name="' + response.name + '" value="' + response.name + '" readonly>' +
                            '<input type="hidden" class="product-id" data-productId="' + response.id + '">' +
                            '</div><!-- input-group -->' +
                            '</div><!-- col-xs-6 -->' +
                            '<!-- Product quantity -->' +
                            '<div class="col-xs-3">' +
                            '<input type="number" class="form-control product-quantity" min="1" data-stock="' + response.stock + '" value="1" placeholder="0" required>' +
                            '</div><!-- col-xs-3 -->' +
                            '<!-- Total price -->' +
                            '<div class="col-xs-3" style="padding-left: 0px">' +
                            '<div class="input-group">' +
                            '<span class="input-group-addon"><i class="ion ion-logo-usd"></i></span>' +
                            '<input type="number" min="1" class="form-control product-price" data-price="' + response.selling_price + '" value="' + response.selling_price + '" required readonly>' +
                            '</div><!-- input-group -->' +
                            '</div><!-- col-xs-3 -->' +
                            '</div><!-- row -->');
                        // calculate the summation of
                        // products price
                        sumTotalPrice();

                        // Calculate the total price with sales tax
                        computeTotal();

                        // Get product list in json format
                        productList();

                    }
                });
            });

            /**
             * Remove product from list
             * */
            $('.sales-form').on('click', 'button.remove-product', function () {

                let productId = $(this).data('product');
                let parentId = '.product-' + productId;

                $(parentId).remove();

                $('[data-product="' + productId + '"]').removeClass('btn-default').addClass('btn-primary product-button');

                if($('#add-product').children().length === 0) {
                    $('#total').val(0);
                    $('#sub-total').val(0);
                } else {

                    // Summation of product prices
                    sumTotalPrice();

                    // Calculate the total price with sales tax
                    computeTotal();

                    // Get product list in json format
                    productList();
                }

            });

        });


        /**
         * Calculate the summation of the price of items
         */
        function sumTotalPrice() {
            // get the price of the item
            let itemPrices = $('.product-price');

            // Array for holding all the price of item
            let priceArray = [];

            // Populate price array
            for (let i = 0; i < itemPrices.length; i++) {
                priceArray.push(Number($(itemPrices[i]).val()));
            }

            /**
             * Function for Calculating the summation
             * @param total
             * @param number
             * @returns {*}
             */
            function sumPriceArray(total, number) {
                return total + number;
            }

            // Calculate the summation
            var totalPrice = priceArray.reduce(sumPriceArray);
            totalPrice = totalPrice.toFixed(2);

            $('.sub-total').val(totalPrice)
        }

        /**
         * Compute total price with sales tax
         */
        function computeTotal() {
            let tax = Number($('#tax').val());
            let subTotal = Number($('#sub-total').val());
            let totalTax = Number(subTotal * tax / 100);
            let total = subTotal + totalTax;

            $('#total').val(total);
        }

        /**
         * Create json object for
         * added products
         */
        function productList() {
            let productList = [];
            let productId = $('.product-id');
            let name = $('.product-name');
            let stock = $('.product-stock');
            let quantity = $('.product-quantity');
            let price = $('.product-price');

            for (let i = 0; i < name.length; i++) {
                productList.push({
                    "id": $(productId).val(),
                    "name": $(name).val(),
                    "quantity": $(quantity).val(),
                    "stock": $(stock).val(),
                    "price": $(price).data('price'),
                    "total": $(price).val()

                });

                $('#products-list').val(JSON.stringify(productList));

            }
        }
    </script>
@endsection
