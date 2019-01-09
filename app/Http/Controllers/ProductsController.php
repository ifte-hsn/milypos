<?php

namespace App\Http\Controllers;

use File;
use Image;
use Input;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Transformers\ProductsTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * Fetch the list of products from database
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
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
            'products.selling_price',
            'products.sales',
            'products.category_id',
            'products.created_at',
            'products.updated_at',
            'products.deleted_at',
        ]);

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


        return (new ProductsTransformer)->transformProducts($products, $total);
    }

    /**
     * Show form for adding new product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_product', Product::class);
        $product = new Product();
        $categories = Category::all();
        return view("products.edit", compact('categories', 'product'));
    }

    /**
     * Store the product into database
     * '
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('add_product', Product::class);

        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products',
            'image' => 'image',
            'sales' => 'nullable|numeric',
            'purchase_price' =>'numeric',
            'selling_price' => 'numeric',
            'category_id' => 'nullable|integer|exists:categories,id'
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->stock = $request->input('stock');
        $product->description = $request->input('description');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->sales = $request->input('sales');
        $product->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $product->name . "_" . str_random(25) . "." . $image->getClientOriginalExtension();
            $path = public_path('uploads/products/' . $file_name);

            if ($image->getClientOriginalExtension() != 'svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $product->image = $file_name;
            } else {
                $image->move(app('products_upload_path'), $file_name);
            }
        }
        if ($product->save()) {
            return redirect()->route('products.index')->with('success', __('products/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($product->getErrors());
    }

    /**
     * Show specific product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id) {
        $this->authorize('edit_product', Product::class);

        return Redirect::route('products.edit', ['id' => $id]);
    }

    /**
     * Show form for editing product
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id) {
        $this->authorize('edit_product', Product::class);
        if($product = Product::findOrFail($id)) {
            $categories = Category::all();
            return view('products.edit', compact('product', 'categories'));
        }
    }

    /**
     * Update product information
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id) {
        $this->authorize('edit_product', Product::class);

        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'image' => 'image',
            'sales' => 'nullable|numeric',
            'purchase_price' =>'numeric',
            'selling_price' => 'numeric',
            'category_id' => 'nullable|integer|exists:categories,id'
        ]);


        try {
            $product = Product::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect()->route('products.index')
                ->with('error', __('products/message.product_not_found', compact('id')));
        }
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->stock = $request->input('stock');
        $product->description = $request->input('description');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->sales = $request->input('sales');
        $product->category_id = $request->input('category_id');

        // Process Image
        if ($request->hasFile('image')) {

            if($product->image != '') {
                // Delete previous file
                $path = public_path('uploads/products/'.$product->image);
                File::delete($path);
            }

            $image = $request->file('image');
            $file_name = $product->name . "_" . str_random(25) . "." . $image->getClientOriginalExtension();
            $path = public_path('uploads/products/' . $file_name);

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $product->image = $file_name;
            } else {
                $image->move(app('products_upload_path'), $file_name);
            }

        }

        if ($product->save()) {
            return redirect()->route('products.index')->with('success', __('products/message.success.update'));
        }
        return redirect()->back()->withInput()->withErrors($product->getErrors());
    }

    /**
     * Delete the product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id) {

        $this->authorize('delete_product', Product::class);

        try {
            $product = Product::findOrFail($id);
            $product->delete();
            $success = __('products/message.success.delete');

            return redirect()->route('products.index')->with('success', $success);
        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('products/message.product_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('products.index')->with('error', $error);
        }
    }

    /**
     * Restore deleted product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRestore($id) {
        $this->authorize('restore_product', Product::class);

        if(!$product = Product::onlyTrashed()->find($id)) {
            return redirect()->route('products.index')->with('error', __('products/message.product_not_found', ['id'=>$id]));
        }

        if ($product->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('products.index')->with('success', __('products/message.success.restored'));
        }
        return redirect()->route('products.index')->with('error', __('products/message.error.could_not_restore'));
    }

    /**
     * Export Products as CSV
     *
     * @return StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportAsCsv() {
        $this->authorize('export_products', Product::class);

        $response = new StreamedResponse(function() {
            // Open output steam
            $handle = fopen('php://output', 'w');
            Product::orderBy('created_at', 'desc')->chunk(500, function ($products) use ($handle) {
                $headers = [
                    // strtolower to prevent Excel from trying to open it as a SYSLK file
                    strtolower(__('general.id')),
                    __('general.name'),
                    __('general.code'),
                    __('general.stock'),
                    __('general.description'),
                    __('general.purchase_price'),
                    __('general.selling_price'),
                    __('general.sales'),
                    __('general.category'),
                    __('general.created_at'),
                ];

                fputcsv($handle, $headers);

                foreach ($products as $product) {


                    $values = [
                        $product->id,
                        $product->name,
                        $product->code,
                        $product->stock,
                        $product->description,
                        $product->purchase_price,
                        $product->selling_price,
                        $product->sales,
                        $product->category->name,
                        $product->created_at,
                    ];

                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-'.date('Y-m-d-his').'.csv"',
        ]);


        return $response;
    }

    /**
     * Bulk Edit products
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkEdit(Request $request)
    {
        $this->authorize('bulk_delete_products', Product::class);

        if ($request->has('ids') && (count($request->input('ids')) > 0)) {
            $product_raw_array = array_keys(Input::get('ids'));

            $products = Product::whereIn('id', $product_raw_array)->get();

            if($request->input('bulk_actions') == 'edit') {
                return view('products.bulk-edit', compact('products'));
            }
            return view('products.confirm-bulk-delete',compact('products'));
        }

        return redirect()->back()->with('error', 'products/message.no_product_selected');
    }


    /**
     * Process Bulk Edit
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkSave(Request $request)
    {
        $this->authorize('bulk_delete_products', Product::class);

        if (!$request->has('ids') || count($request->input('ids')) == 0) {

            return redirect()->route('products.index')->with('error', __('products/message.no_product_selected'));
        } else {
            $product_raw_array = Input::get('ids');

            $products = Product::whereIn('id', $product_raw_array)->get();

            foreach ($products as $product) {
                $product->delete();
            }
            return redirect()->route('products.index')->with('success', __('products/message.success.selected_product_deleted'));
        }
    }

    /**
     * Show all products of a category
     * @param $id
     */
    public function getProductsByCategory($id) {

    }
}
