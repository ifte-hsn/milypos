<?php

namespace App\Http\Controllers;

use App\Models\Sale;
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
            'sales.id',
            'sales.user_id',
            'sales.client_id',
            'sales.products',
            'sales.tax',
            'sales.net',
            'sales.total',
            'sales.payment_method'
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
                    'payment_method'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';
                $sales = $sales->orderBy($sort, $order);
                break;
        }

        $total = $sales->count();
        $sales = $sales->skip($offset)->take($limit)->get();
        return (new SalesTransformer)->transformSales($sales, $total);
    }
}
