<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ProductsTransformer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Transformers\SalesTransformer;

class SalesController extends Controller
{
    public function manage()
    {
        $this->authorize('view_sales', Sale::class);
        return view('sales.index');
    }

    public function getSalesList(Request $request)
    {
        $this->authorize('view_sales', Sale::class);

        $sales = Sale::select([
            '*'
        ]);

        if(($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $sales = $sales->GetDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $sales = $sales->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);


        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'id', 'tax', 'net', 'total',
                    'payment_method', 'code'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';
                $sales = $sales->orderBy($sort, $order);
                break;
        }

        $total = $sales->count();
        $sales = $sales->skip($offset)->take($limit)->get();


        return (new SalesTransformer)->transformSales($sales, $total);
    }


    /**
     * Show form for new sales creation.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $sale = new Sale();

        // Generate Code for new sales
        // We need to generate code in sequential order
        // So we need to get last sales code
        // than add 1 to it.
        // This will our new code for new sales
        $sale_code = Sale::orderBy('id', 'desc')->take(1)->get();



        // Add 1 to generate new code
        $new_sale_code = (isset($sale_code[0])) ? $sale_code[0]->code + 1 : 1;


        $sale->code = $new_sale_code;

        $clients = Client::all();

        return view('sales.edit', compact('sale', 'clients'));
    }


    public function getProductById(Request $request) {
        $product = Product::findOrFail($request->input('product_id'));
        return $product;
    }


    /**
     * Get product list with pagination
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProductList(Request $request)
    {
        $this->authorize('view_product', Product::class);

        $products = Product::select(['*']);

        if (($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $products = $products->GetDeleted();
        }
        if ($request->has('search') && $request->input('search') != '') {
            $products = $products->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 20);


        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'name', 'code', 'stock', 'description',
                    'purchase_price', 'selling_price', 'sales', 'category.name', 'id'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'name';
                $products = $products->orderBy($sort, $order);
                break;
        }

        $total = $products->count();
        $products = $products->skip($offset)->take($limit)->get();


        return (new ProductsTransformer)->transformProductsForSale($products, $total);
    }
    /**
     * Get all products from database
     */
    public function getAllProducts(Request $request) {
        $this->authorize('create_sales', Product::class);

        $products = Product::all();
        return $products;
    }
}
