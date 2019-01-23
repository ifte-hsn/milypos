<?php

namespace App\Http\Transformers;


use Auth;
use App\Models\Sale;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Collection;

class SalesTransformer
{
    public function transformSales(Collection $sales, $total)
    {
        $array = array();
        foreach ($sales as $sale) {
            $array[] = self::transformSale($sale);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformSale(Sale $sale)
    {

        $array = [
            'id' => (int) $sale->id,
            'seller' => ($sale->user->fullName) ? e($sale->user->fullName) : null,
            'client' => ($sale->client->fullName) ? e($sale->client->fullName) : null,
            'code' => $sale->code,
//            'products' => ($sale->products) ? e($sale->products) : null,
            'tax' => e($sale->tax),
            'sub_total' => e($sale->subtotal),
            'total'=>e($sale->total),
            'payment_method' => e($sale->payment_method),
            'created_at' => Helper::getFormattedDateObject($sale->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($sale->updated_at, 'datetime'),
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'print' =>(Auth::user()->can('print_sale') && ($sale->deleted_at=='')) ? true : false,
            'update' => (Auth::user()->can('edit_sale') && ($sale->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('delete_sale') && ($sale->deleted_at=='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformSalesDatatable($sales) {
        return (new DatatablesTransformer)->transformDatatables($sales);
    }
}