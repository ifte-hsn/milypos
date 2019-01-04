@extends('layouts.default')
@section('title')
{{ __('general.bulk_checkin_and_delete') }}
@parent
@endsection

@section('breadcrumb')
<li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
<li><a href="{{ route('products.index') }}"><i class="fa fa-th"></i> {{ __('general.products') }}</a></li>
<li class="active">{{ __('general.bulk_checkin_and_delete') }}</li>
@endsection

@section('content')
<div class="box box-danger">
    <form action="{{ route('products.bulkSave') }}" class="form-horizontal" method="POST" id="bulkForm">
        <div class="box-body">

            @csrf
            <div class="callout callout-danger">
                <i class="fa fa-exclamation-circle"></i>
                <strong>{{ __('general.warning') }}: </strong>
                {{ __('products/message.bulk_delete_warning', ['count' => count($products) ]) }}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>{{ __('general.image') }}</th>
                                <th>{{ __('general.id') }}</th>
                                <th>{{ __('general.name') }}</th>
                                <th>{{ __('general.code') }}</th>
                                <th>{{ __('general.category') }}</th>
                                <th>{{ __('general.stock') }}</th>
                                <th>{{ __('general.purchase_price') }}</th>
                                <th>{{ __('general.selling_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $product->id }}" checked>
                                </td>
                                <td>
                                    @if($product->image)
                                        <a href="{{ url('/') }}/uploads/products/{{ $product->image }}" data-toggle="lightbox" data-type="image">
                                            <img src="{{ url('/') }}/uploads/products/{{ $product->image }}" alt="{{ $product->name }}" style="max-height: 50px; width: auto;" class="img-responsive">
                                        </a>
                                    @else
                                        <a href="{{ url('/').'/images/products_placeholder.png' }}" data-toggle="lightbox" data-type="image">
                                            <img src="{{ url('/').'/images/products_placeholder.png' }}" alt="{{ $product->name }}" style="max-height: 50px; width: auto;" class="img-responsive">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $product->id }}
                                </td>
                                <td>
                                    {{ $product->name }}
                                </td>
                                <td>
                                    {{ $product->code }}
                                </td>
                                <td>
                                    {{ ($product->category) ? $product->category->name : "--" }}
                                </td>
                                <td>
                                    {{ $product->stock }}
                                </td>

                                <td>
                                    {{ $product->purchase_price }}
                                </td>

                                <td>
                                    {{ $product->selling_price }}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- col-md-12 -->
            </div><!-- .row -->
        </div><!-- box-body -->
        <div class="box-footer text-right">
            <a class="btn btn-link" href="{{ URL::previous() }}">{{ __('general.cancel') }}</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.submit') }}</button>
        </div><!-- box-footer text-right -->
    </form>
</div><!-- .box -->
@endsection
