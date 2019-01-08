<?php

namespace App\Http\Transformers;

use Auth;
use Illuminate\Database\Eloquent\Collection;

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
            'update' => (Auth::user()->can('edit_role') && ($role->deleted_at=='') && $role->name != 'Super Admin')  ? true : false,
            'delete' =>(Auth::user()->can('delete_role') && ($role->deleted_at=='') && $role->name != 'Super Admin') ? true : false,
            'restore' => (Auth::user()->can('restore_role') && ($role->deleted_at!='') && $role->name != 'Super Admin') ? true : false,
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