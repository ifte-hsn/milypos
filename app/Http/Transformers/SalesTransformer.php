<?php

namespace App\Http\Transformers;


use App\Models\Sale;
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
            'seller' => e($sale->user->name),
            'client' => e($sale->client->name),
            'payment_method' => e($sale->payment_method),
            'payment_method' => e($sale->tax),
            'net' => e($sale->net),
            'total'=>e($sale->total),
            'created_at' => Helper::getFormattedDateObject($sale->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($sale->updated_at, 'datetime'),
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('edit_sale') && ($sale->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('delete_sale') && ($sale->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('restore_sale') && ($sale->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformSalesDatatable($sales) {
        return (new DatatablesTransformer)->transformDatatables($sales);
    }
}