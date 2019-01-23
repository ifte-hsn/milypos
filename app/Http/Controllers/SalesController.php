<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ProductsTransformer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Transformers\SalesTransformer;

class SalesController extends Controller
{
    /**'
     * Show page for managing sales
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function manage()
    {
        $this->authorize('view_sales', Sale::class);
        return view('sales.index');
    }

    /**
     * Return list of sales
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSalesList(Request $request)
    {
        $this->authorize('view_sales', Sale::class);

        $sales = Sale::select(['*']);

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

    /**
     * Store a newly created sale in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
            'client_id' => 'required|numeric|exists:clients,id',
            'sales_code' => 'required|unique:sales,code',
            'tax'        => 'nullable|numeric',
            'subtotal'   => 'required',
            'total'     => 'required',
            'payment_method' => 'required'
        ]);

        /**===============================================
         * Update the customer's purchase and reduce the
         * stock and increase the sales of the product
         ===============================================*/
        $productList = json_decode($request->input('products'), true);
        $totalProductPurchased = array();

        foreach ($productList as $key => $value) {
            array_push($totalProductPurchased, $value['quantity']);
            $product = Product::findOrFail($value['id']);

            // Calculate new sold quantity
            $product->sales = $value['quantity']+$product->sales;
            $product->stock = $value['stock'];
            $product->save();
        }


        /*===============================================
        Store Sale
        ================================================*/
        $sale = new Sale();
        $sale->user_id = $request->input('user_id');
        $sale->client_id = $request->input('client_id');
        $sale->code = $request->input('sales_code');
        $sale->products = $request->input('products');
        $sale->tax = $request->input('tax');
        $sale->subtotal = (float) $request->input('subtotal');
        $sale->total = (float) $request->input('total');

        if($request->input('payment_method') === 'TC') {
            $sale->payment_method = 'TC-'.$request->input('card_no');
        } else if($request->input('payment_method') === 'TD'){
            $sale->payment_method = 'TD-'.$request->input('card_no');
        } else {
            $sale->payment_method = __('general.cash');
        }


        $sale->save();

        /*=======================================================
        Update client's last purchase and shopping count
        ========================================================*/
        $client = Client::findOrFail($request->input('client_id'));

        $client->shopping = $client->shopping + array_sum($totalProductPurchased);
        $client->last_purchase = $sale->created_at;
        $client->save();

        return redirect()->back()->with('success', __('Sale complete!'));
    }

    /**
     * Show the form for editing the specified sale.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $sale = Sale::findOrFail($id);
        $clients = Client::all();

        return view('sales.edit', compact('sale', 'clients'));
    }

    /**
     * Update the specified sale in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Fetch sell by id from database
        $sale = Sale::findOrFail($id);

        // If user do not change any thing in the sale
        // then there will no change in product list
        // hence we do not need to update product list in sold item
        if($request->input('products') == "") {
            $productList = $sale->products;
            $combineProduct = false;
        } else {
            $productList = $request->input('products');
            $combineProduct = true;
        }

        /*
        | -----------------------------------------------------------------
        | Adjusting Product and Client before updating sales
        |------------------------------------------------------------------
        | At first we need to update product stock and total quantity sold,
        | and number of item purchased by client.
        | For adjusting product stock we need to get the product by
        | product id and than add quantity of previously sold
        | with product stock.
        |
        | To update sold quantity, we need to subtract quantity
        | previously sold quantity with product's current sales
        |
        */

        if($combineProduct) {
            // Previous Sold products in this sell
            $oldProductList = json_decode($sale->products, true);
            // Array to hold the previous quantity of total products purchased
            // in this sell
            $oldTotalProductPurchesed = array();

            foreach ($oldProductList as $key => $value) {
                array_push($oldTotalProductPurchesed, $value['quantity']);

                // get products by id and update stock and sale
                $product = Product::findOrFail($id);

                // update soled quantity and stock
                $product->sales = $product->sales - $value['quantity'];
                $product->stock = $value['quantity'] + $product->stock;
                $product->save();
            }

            /*=======================================================
            Update client's last purchase and shopping count
            ========================================================*/
            $client = Client::findOrFail($request->input('client_id'));

            $client->shopping = $client->shopping - array_sum($oldTotalProductPurchesed);
            $client->save();



            /*===============================================
            Now its time to update
            ================================================*/

            /**===============================================
             * Update the customer's purchase and reduce the
             * stock and increase the sales of the product
            ===============================================*/
            $productList = json_decode($request->input('products'), true);
            $totalProductPurchased = array();

            foreach ($productList as $key => $value) {
                array_push($totalProductPurchased, $value['quantity']);
                $product = Product::findOrFail($value['id']);

                // Calculate new sold quantity
                $product->sales = $value['quantity'] + $product->sales;
                $product->stock = $value['stock'];
                $product->save();
            }


            /*=======================================================
            Update client's last purchase and shopping count
            ========================================================*/
            $client = Client::findOrFail($request->input('client_id'));

            $client->shopping = $client->shopping + array_sum($totalProductPurchased);
            $client->save();

            /*===============================================
            Store Sale
            ================================================*/
            $sale->user_id = $request->input('user_id');
            $sale->client_id = $request->input('client_id');
            $sale->code = $request->input('sales_code');
            $sale->products = $request->input('products');
            $sale->tax = $request->input('tax');
            $sale->subtotal = (float) $request->input('subtotal');
            $sale->total = (float) $request->input('total');

            if($request->input('payment_method') === 'TC') {
                $sale->payment_method = 'TC-'.$request->input('card_no');
            } else if($request->input('payment_method') === 'TD'){
                $sale->payment_method = 'TD-'.$request->input('card_no');
            } else {
                $sale->payment_method = __('general.cash');
            }
            $sale->save();
        }
        return redirect()->route('sales.manage')->with('success', __('Sale complete!'));
    }

    /**
     * Remove the specified sale from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id) {
        // Update last purchase date of client
        // step 1: Get sale by id
        $sale = Sale::findOrFail($id);
        // step 2: Get all sale by client id. We can get this client_id from step 1.
        $getAllSalesoFClient = Sale::where('client_id', $sale->client_id)->orderBy('id', 'asc')->get();
        $purchasedDates = array();

        foreach ($getAllSalesoFClient as $key => $value) {
            array_push($purchasedDates, $value['created_at']);
        }

        $client = Client::findOrFail($sale->client_id);

        // step 3: Update last purchase. Last purchase date will be the date before last sales date.
        if(count($purchasedDates) > 1) {
            if($sale->created_at > $purchasedDates[count($purchasedDates)-2]) {
                $client->last_purchase = $purchasedDates[count($purchasedDates)-2];
                $client->save();
            } else {
                $client->last_purchase = $purchasedDates[count($purchasedDates)-1];
                $client->save();
            }
        } else {
            $client->last_purchase = null;
            $client->save();
        }

        // now process products
        $productList = json_decode($sale->products, true);
        $toalPurchesedProducts = array();

        foreach ($productList as $key => $value) {
            array_push($toalPurchesedProducts, $value['quantity']);

            // get products by id and update stock and sale
            $product = Product::findOrFail($id);

            // update soled quantity and stock
            $product->sales = $product->sales - $value['quantity'];
            $product->stock = $value['quantity'] + $product->stock;
            $product->save();
        }


        $client->shopping = $client->shopping - array_sum($toalPurchesedProducts);
        $client->save();

        $sale->delete();

        return redirect()->route('sales.manage')->with('success', __('Sale deleted!'));

    }


    /**
     * Get product by id
     *
     * @param Request $request
     * @return mixed
     */
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
     * Get all products from database from database
     */
    public function getAllProducts(Request $request) {
        $this->authorize('create_sales', Product::class);

        $products = Product::all();
        return $products;
    }


}
