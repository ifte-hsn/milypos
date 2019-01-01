<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ProductsTransformer;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    /**
     * Show products list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_product', Product::class);
        return view('products.index');
    }

    public function getProductList(Request $request)
    {
        $this->authorize('view_product', Product::class);

        $products = Product::select([
            'products.id',
            'products.name',
            'products.code',
            'products.image',
            'products.stock',
            'products.description',
            'products.purchase_price',
            'products.sell_price',
            'products.sales',
            'products.category_id',
            'products.created_at',
            'products.updated_at',
        ]);

        if(($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $products = $products->GetDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $products = $products->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);


        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'name', 'code', 'stock', 'description',
                    'purchase_price', 'sell_price', 'sales', 'category.name','id'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'name';
                $products = $products->orderBy($sort, $order);
                break;
        }

        $total = $products->count();
        $products = $products->skip($offset)->take($limit)->get();

        return (new ProductsTransformer)->transformProducts($products, $total);
    }
}
