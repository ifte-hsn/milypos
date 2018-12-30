<?php

namespace App\Http\Transformers;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class RolesTransformer
{
    private static function transformRole($role)
    {
        $array = [
            'id' => (int) $role->id,
            'name' => $role->name,
        ];

        // Permissions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('Edit Role') && ($role->deleted_at=='') && $role->name != 'Super Admin')  ? true : false,
            'delete' =>(Auth::user()->can('Delete Role') && ($role->deleted_at=='') && $role->name != 'Super Admin') ? true : false,
            'restore' => (Auth::user()->can('Restore Role') && ($role->deleted_at!='') && $role->name != 'Super Admin') ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformRoles(Collection $roles, $total) {
        $array = array();
        foreach ($roles as $role) {
            $array[] = self::transformRole($role);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
}