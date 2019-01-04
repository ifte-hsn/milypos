@extends('layouts.default')
@section('title')
    @if($product->id)
        {{ __('products/message.update_product') }}
    @else
        {{ __('products/message.add_product') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('products.index') }}"><i class="fa fa-user"></i> {{ __('general.products')  }}</a></li>
    @if($product->id)
        <li class="active">{{ __('products/message.update_product') }}</li>
    @else
        <li class="active">{{ __('products/message.add_product') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="post" autocomplete="off"
                  action="{{ ($product) ? route('products.update', ['product'=> $product->id]) : route('products.store') }}"
                  class="form-horizontal form-label-left" id="product-form" enctype="multipart/form-data">
                @csrf
                @if($product->id)
                    @method('PUT')
                @endif

                <div class="box-body">
                    <!--==========================
                    =            Image          =
                    ==========================-->

                    <div class="form-group">
                        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                            @if ($product->image)
                                <img src="{{ url('/') }}/uploads/products/{{ $product->image }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 200px;"/>
                            @endif
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->

                    </div>
                    @include ('partials.forms.edit.image-upload')

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.name') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'name')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.name') }}"
                                   value="{{ Input::old('name', $product->name) }}">
                            {!! $errors->first('name', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.code') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'code')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="code" name="code" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.code') }}"
                                   value="{{ Input::old('code', $product->code) }}">
                            {!! $errors->first('code', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('stock') ? 'has-error' : '' }}">
                        <label for="stock" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.stock') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'stock')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="stock" name="stock" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.stock') }}"
                                   value="{{ Input::old('stock', $product->stock) }}">
                            {!! $errors->first('stock', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.description') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'description')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="description" name="description" class="form-control col-md-7 col-xs-12" cols="30" rows="10">{{ Input::old('description', $product->description) }}</textarea>
                            {!! $errors->first('description', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div class="form-group {{ $errors->has('purchase_price') ? 'has-error' : '' }}">
                        <label for="purchase_price" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.purchase_price') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'purchase_price')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" min="0" step="any" id="purchase_price" name="purchase_price" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.purchase_price') }}"
                                   value="{{ Input::old('purchase_price', $product->purchase_price) }}">
                            {!! $errors->first('purchase_price', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div class="form-group {{ $errors->has('selling_price') ? 'has-error' : '' }}">
                        <label for="selling_price" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.selling_price') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'selling_price')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" min="0" step="any" id="selling_price" name="selling_price" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.selling_price') }}"
                                   value="{{ Input::old('selling_price', $product->selling_price) }}">
                            {!! $errors->first('selling_price', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div class="form-group">
                        <label for="use_percentage" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.use_percentage') }}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="use_percentage" id="use_percentage" class="percentage" type="checkbox">
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div class="form-group">
                        <label for="percentage" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.percentage') }}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="input-group">
                                <input type="number" step="any" min="0" max="100" value="40" class="form-control newPercentage" id="percentage" name="percentage">
                                <div class="input-group-addon">%</div>
                            </div>

                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label for="category_id" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.category') }} {!! (\App\Helpers\Helper::checkIfRequired($product, 'category_id')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <select name="category_id" id="category_id" class="form-control select2 col-md-7 col-xs-12">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected="selected"' : '""' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('category_id', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->


                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-6">
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
                            </button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

@section('page_scripts')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });


            /*=============================================
                    ADDING SELLING PRICE
            =============================================*/
            $("#purchase_price").change(function(){

                if($(".percentage").prop("checked")){

                    var valuePercentage = $(".newPercentage").val();
                    var percentage = Number(($("#purchase_price").val()*valuePercentage/100))+Number($("#purchase_price").val());
                    $("#selling_price").val(percentage);
                    $("#selling_price").prop("readonly",true);
                }
            });


            /*=============================================
            PERCENTAGE CHANGE
            =============================================*/
            $(".newPercentage").change(function(){

                if($(".percentage").prop("checked")){

                    var valuePercentage = $(this).val();

                    var percentage = Number(($("#purchase_price").val()*valuePercentage/100))+Number($("#purchase_price").val());

                    $("#selling_price").val(percentage);
                    $("#selling_price").prop("readonly",true);
                }

            });


            $(".percentage").on("ifUnchecked",function(){
                $("#selling_price").prop("readonly",false);
            });

            $(".percentage").on("ifChecked",function(){
                $("#selling_price").prop("readonly",true);
            });
        });
    </script>
@endsection