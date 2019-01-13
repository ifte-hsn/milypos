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
                                <div class="input-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="seller"
                                           value="{{ Auth::user()->fullName }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    {!! $errors->first('user_id', '<span class="alert-msg">:message</span>') !!}
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ********************** -->
                            <!--        Sales Code     -->
                            <!-- ********************** -->
                            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control" id="sales_code" name="sales_code"
                                           value="{{ $sale->code }}"
                                           readonly>
                                    {!! $errors->first('code', '<span class="alert-msg">:message</span>') !!}
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ***************** -->
                            <!--        Client     -->
                            <!-- ***************** -->
                            <div class="form-group">
                                <div class="input-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
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
                                    {!! $errors->first('client_id', '<span class="alert-msg">:message</span>') !!}
                                </div><!-- input-group -->
                            </div><!-- form-group -->


                            <!-- ******************************* -->
                            <!--    Entry for adding product     -->
                            <!-- ******************************* -->
                            <table class="table table-condensed table-bordered table-striped table-responsive" id="pos-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('general.products') }}</th>
                                        <th>{{ __('general.quantity') }}</th>
                                        <th>{{ __('general.price') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>

                            <input type="hidden" id="products-list" name="products">

                            <!-- hidden button to show only on small screen -->
                            <button class="btn btn-default hidden-lg" type="button" id="add-product-btn">Add Product</button>

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
                                                <div class="input-group {{ $errors->has('tax') ? 'has-error' : '' }}">
                                                    <input type="text" class="form-control" id="tax" name="tax"
                                                           min="0" placeholder="0">
                                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                                    {!! $errors->first('tax', '<span class="alert-msg">:message</span>') !!}
                                                </div><!-- input-group -->
                                            </td>

                                            <td style="width: 35%">
                                                <div class="input-group {{ $errors->has('subtotal') ? 'has-error' : '' }}">
                                                    <span class="input-group-addon"><i
                                                                class="ion ion-logo-usd"></i></span>
                                                    <input type="text" class="form-control sub-total" id="sub-total" min="1"
                                                           placeholder="00000" data-subtotal="0" required readonly>
                                                    <input type="hidden" class="sub-total" name="subtotal">
                                                    {!! $errors->first('subtotal', '<span class="alert-msg">:message</span>') !!}
                                                </div><!-- input-group -->
                                            </td>

                                            <td style="width: 40%">
                                                <div class="input-group {{ $errors->has('total') ? 'has-error' : '' }}">
                                                    <span class="input-group-addon"><i
                                                                class="ion ion-logo-usd"></i></span>
                                                    <input type="text" class="form-control total" id="total"
                                                           min="1"
                                                           placeholder="00000" data-total="0" required readonly>
                                                    <input type="hidden" name="total" class="total">
                                                    {!! $errors->first('total', '<span class="alert-msg">:message</span>') !!}
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
                            <div class="form-group row payment-method-row {{ $errors->has('payment_method') ? 'has-error' : '' }}">

                                <div class="col-xs-4 method-select" style="padding-right: 0px;">
                                    <select name="payment_method" id="payment_method" class="form-control select2">
                                        <option value="">Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="TC">Credit Card</option>
                                        <option value="TD">Debit Card</option>
                                    </select>
                                    {!! $errors->first('payment_method', '<span class="alert-msg">:message</span>') !!}
                                </div><!-- col-xs-4 -->

                                <div class="col-xs-4 cash hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ion ion-logo-usd"></i>
                                        </span>
                                        <input type="text" class="form-control" id="amount_paid" placeholder="000000">
                                    </div>
                                </div>

                                <div class="col-xs-4 change hidden">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ion ion-logo-usd"></i>
                                        </span>
                                        <input type="text" class="form-control" id="change" placeholder="000000" readonly>
                                    </div>
                                </div>

                                <div class="col-xs-8 card hidden">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="card_no">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div><!-- col-xs-6 -->

                            </div><!-- form-group row -->

                            <br>
                        </div><!-- box -->
                    </div><!-- box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save Sale</button>
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
                            data-cookie-id-table="productsTable"
                            data-pagination="true"
                            data-id-table="productsTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="false"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="products-table"
                            class="table table-bordered table-striped milypos-table products-table"
                            data-url="{{ route('sales.products.list')  }}">

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
        /*=========================================================
        Adding product to pos-table
        ==========================================================*/

        var posTable = $('#pos-table');
        $('#products-table').on('click', 'button.add-product-button', function () {
            $productId = $(this).data('productid');
            $(this).removeClass('btn-primary add-product-button');
            $(this).addClass('btn-default');

            // Ajax request
            $.ajax({
                url: "{{ route('sales.product.byId') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: $productId
                },
                success: function (response) {
                    if (response.stock == 0) {
                        $('[data-product="' + response.id + '"]').removeClass('btn-default').addClass('btn-primary add-product-button');
                        alert('this product is out of stock');
                        return;
                    }
                    $('#pos-table tbody').append('<tr id="product-'+response.id+'">' +
                        '<td><button class="btn btn-xs btn-danger remove-product" type="button" data-productid="'+response.id+'"><i class="fa fa-times"></i></button></td>' +
                        '<td><span data-productname="'+response.name+'" data-productid="'+response.id+'" class="product-name">'+response.name+'</span></td>' +
                        '<td><input type="number" class="form-control product-quantity" value="1" min="1" step="any" data-productquantity="1" data-productstock="'+Number(response.stock)+'" data-newstock="'+Number(response.stock-1)+'"></td>' +
                        '<td><input type="text" class="form-control product-price" value="'+response.selling_price+'" data-unitprice="'+response.selling_price+'" data-producttotal="'+response.selling_price+'"></td>' +
                        '</tr>');

                    // sum total price
                    calculateSum();

                    // calculate total price including tax
                    calculateTotalWithTax();

                    // generate product list in json format
                    generateProductList();

                    $(".product-price, #sub-total, #total").number(true, 2);
                    
                }
            });

        });


        /*============================================
         Remove product from pos table
        =============================================*/
        posTable.on('click', 'button.remove-product', function () {
            $(this).closest('tr').remove();
            let productId = $(this).data('productid');

            // $('#pos-table tr#product-'+productId).remove();
            //
            // $(this).removeClass('btn-primary add-product-button');
            // $(this).addClass('btn-default');

            $('[data-productid="' + productId + '"]').removeClass('btn-default').addClass('btn-primary add-product-button');

            if($('#pos-table tbody').children().length === 0) {
                $('#sub-total').val(0)
                    .data('subtotal',0);
                $('.sub-total').val(0);
                $('#total').val(0).data('total', 0);
                $('.total').val(0).data('total', 0);
            } else {
                // sum total price
                calculateSum();

                // calculate total price including tax
                calculateTotalWithTax();

                // generate product list in json format
                generateProductList();
            }
        });
        /*===============================================================
        Adding product to pos table when add product button is clicked
        This add product button is visible only on smaller device.
        So we need separate logic for that
        ==============================================================*/
        var productNo = 0;
        $('#add-product-btn').on('click', function () {
            productNo++;
            $.ajax({
                "url" : "{{ route('sales.products.all')  }}",
                "type": "GET",
                success: function (response) {
                    $('#pos-table tbody').append('<tr id="product-">' +
                        '<td><button class="btn btn-xs btn-danger remove-product" type="button" data-productid=""><i class="fa fa-times"></i></button></td>' +
                        '<td><select class="form-control select-product product-name" data-productname="" data-productid="" id="product'+productNo+'">' +
                            '<option>Please select product</option>'+
                        '</select></td>' +
                        '<td><input type="number" class="form-control product-quantity" value="1" min="1" step="any" data-productquantity="1" data-productstock="" data-newstock=""></td>' +
                        '<td><input type="text" class="form-control product-price" value="" data-unitprice="" data-producttotal=""></td>' +
                        '</tr>');
                    
                    response.forEach(function (item, index) {
                        if(item.stock !== 0){
                            $('#product'+productNo).append(
                                '<option data-productid="'+item.id+'" value="'+item.name+'">'+item.name+'</option>'
                            )

                        }
                    });

                    calculateSum();
                    calculateTotalWithTax();
                }
            });
        });

        /*=============================================
         Populate quantity, price on select product
         =============================================*/
        posTable.on('change', 'select.select-product', function () {
            var $this = $(this);
            let selectedItem = $this.find(':selected');
            let productId = selectedItem.data('productid');
            let productName = selectedItem.val();
            let quanity = $this.closest('tr').find('.product-quantity');
            let price = $this.closest('tr').find('.product-price');

            $this.data('productname', productName).data('productid',productId);

            $.ajax({
                url: "{{ route('sales.product.byId') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: productId
                },
                success: function (response) {
                    let sellingPrice = response.selling_price;
                    quanity.val(1);
                    price.val(sellingPrice);
                    price.data('unitprice',sellingPrice);
                    price.data('producttotal', sellingPrice);

                    quanity.data('productstock', Number(response.stock));
                    quanity.data('newstock', Number(response.stock-1));

                    calculateSum();
                    calculateTotalWithTax();
                    generateProductList();

                    $(".product-price, #sub-total, #total").number(true, 2);
                }
            });

        });


        /*===================================================
        Update subtotal when change quantity
        ====================================================*/
        posTable.on('keyup change','.product-quantity',function () {
            let $this = $(this);
            let quantity = $this.val();
            var stock = $this.data('productstock');
            var newStock = $this.data('newstock');

            if(Number(quantity) > Number(stock)) {
                $this.val(1);
                quantity = 1;
                $this.data('productquantity', 1);
                alert('Insufficient Stock!');
                return;
            }



            newStock = Number(stock-quantity);

            $this.data('newstock', Number(newStock));

            let priceFiels = $this.closest('tr').find('.product-price');
            let unitPrice = priceFiels.data('unitprice');
            let price = Number(quantity*unitPrice);

            priceFiels.data('producttotal', price);
            priceFiels.val(price);

            calculateSum();
            calculateTotalWithTax();
            generateProductList();

            $(".product-price, #sub-total, #total").number(true, 2);

        });

        $(".product-price, #sub-total, #total").number(true, 2);
        /*============================================
        Update total on change tax
        =============================================*/
        $('#tax').on('keyup',function () {
            calculateTotalWithTax();
        });

        /*============================================
        Calculate the sum of product price (Subtotal)
        =============================================*/
        function calculateSum() {
            let itemPrice = $('.product-price');
            let priceArray = [];

            for(let i = 0; i < itemPrice.length; i++) {
                priceArray.push(Number($(itemPrice[i]).val()));
            }

            function sumPriceArray(total, number) {
                return total+number;
            }

            let sumTotalPrice = priceArray.reduce(sumPriceArray);
            $('#sub-total').val(sumTotalPrice)
                .data('subtotal',sumTotalPrice);
            $('.sub-total').val(sumTotalPrice);
            $('#total').val(sumTotalPrice).data('total', sumTotalPrice);
            $('.total').val(sumTotalPrice);

        }

        /*=============================================
        Calculate total price with tax
        =============================================*/
        function calculateTotalWithTax() {
            let tax = $('#tax').val();
            let subTotal = $('#sub-total').data('subtotal');

            let totalTax = Number(subTotal * (tax/100));
            let totalCalculatedPrice = Number(subTotal) + Number(totalTax);

            $('#total').val(totalCalculatedPrice).data('total', totalCalculatedPrice);
            $('.total').val(totalCalculatedPrice);
        }

        /*===========================================
        Product list to json
        ============================================*/
        function generateProductList() {
            let productList = [];

            let name = $('.product-name');
            let quantity = $('.product-quantity');
            let price = $('.product-price');

            for(let i = 0; i<name.length; i++) {
                productList.push(
                    {
                        'id' : $(name).data('productid'),
                        'name' : $(name).data('productname'),
                        'quantity' : $(quantity).data('productquantity'),
                        'stock' : $(quantity).data('newstock'),
                        'price': $(price).data('unitprice'),
                        "total" : $(price).data('producttotal')
                    }
                );
                console.log(productList);
                $("#products-list").val(JSON.stringify(productList));
            }
        }

        // payment_method

        $('#payment_method').on('change', function () {
            method = $(this);

            if(method.val() === 'cash') {
                method.closest('.payment-method-row').find('.cash').removeClass('hidden');
                method.closest('.payment-method-row').find('.change').removeClass('hidden');
                method.closest('.payment-method-row').find('.card').addClass('hidden');

                $('#amount_paid').number( true, 2);
                $('#change').number( true, 2);
            } else {
                method.closest('.payment-method-row').find('.cash').addClass('hidden');
                method.closest('.payment-method-row').find('.change').addClass('hidden');
                method.closest('.payment-method-row').find('.card').removeClass('hidden');
            }
        });


        /*=============================================
        Change in cash
        =============================================*/
        $('.sales-form').on('keyup','input#amount_paid',function () {
            let cash = $(this).val();
            let change =  Number(cash) - Number($('input#total').val());

            $('input#change').val(change);
        });
    </script>
@endsection
