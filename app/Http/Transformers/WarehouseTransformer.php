<?php

namespace App\Http\Transformers;


use App\Helpers\Helper;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;
use Auth;
class WarehouseTransformer
{
    public function transformWarehouses(Collection $warehouses, $total)
    {
        $array = array();
        foreach ($warehouses as $warehouse) {
            $array[] = self::transformWarehouse($warehouse);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformWarehouse(Warehouse $warehouses)
    {
        $array = [
            'id' => (int) $warehouses->id,
            'code' => (int) $warehouses->code,
            'name'=> $warehouses->name,
            'phone' => ($warehouses->phone) ? e($warehouses->phone) : null,
            'email' => ($warehouses->email) ? e($warehouses->email) : null,
            'address' => ($warehouses->address) ? e($warehouses->address) : null,
            'contact_persons' => ($warehouses->contactPersons) ? ($warehouses->contactPersons) : null,
            'created_at' => Helper::getFormattedDateObject($warehouses->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($warehouses->updated_at, 'datetime'),
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('edit_warehouse') && ($warehouses->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('delete_warehouse') && ($warehouses->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('restore_warehouse') && ($warehouses->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformWarehousesDatatable($clients) {
        return (new DatatablesTransformer)->transformDatatables($clients);
    }
}