<?php

namespace App\Http\Transformers;


use App\Helpers\Helper;
use App\Models\Product;
use Auth;

use Illuminate\Database\Eloquent\Collection;

class ProductsTransformer
{
    public function transformProducts(Collection $products, $total)
    {
        $array = array();
        foreach ($products as $product) {
            $array[] = self::transformProduct($product);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformProduct(Product $product)
    {
        $image = url('/').'/images/products_placeholder.png';

        if($product->image) {
            $image = url('/').'/uploads/products/'.$product->image;
        }

        $array = [
            'id' => (int) $product->id,
            'name'=> $product->name,
            'code'=>$product->code,
            'image'=>$image,
            'stock'=>$product->stock,
            'description'=>$product->description,
            'purchase_price'=>$product->purchase_price,
            'selling_price'=>$product->selling_price,
            'sales'=>$product->sales,
            'category'=> ($product->category) ? e($product->category->name) : null,
            'created_at' => Helper::getFormattedDateObject($product->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($product->updated_at, 'datetime'),
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('edit_product') && ($product->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('delete_product') && ($product->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('restore_product') && ($product->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformProductsDatatable($products) {
        return (new DatatablesTransformer)->transformDatatables($products);
    }
}