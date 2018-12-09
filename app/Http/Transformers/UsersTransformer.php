<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class UsersTransformer
{

    public function transformUsers(Collection $users, $total)
    {
        $array = array();
        foreach ($users as $user) {
            $array[] = self::transformUser($user);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformUser(User $user)
    {
        $array = [
            'id' => (int) $user->id,
            'name'=> $user->fullName,
            'first_name' => e($user->first_name),
            'last_name' => e($user->last_name),
            'phone' => ($user->phone) ? e($user->phone) : null,
            'address' => ($user->address) ? e($user->address) : null,
            'city' => ($user->city) ? e($user->city) : null,
            'state' => ($user->state) ? e($user->state) : null,
            'country' => ($user->country) ? e($user->country) : null,
            'zip' => ($user->zip) ? e($user->zip) : null,
            'email' => ($user->email) ? e($user->email) : null,
            'activated' => ($user->activated) ? e($user->activated) : null,
            'created_at' => Helper::getFormattedDateObject($user->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($user->updated_at, 'datetime'),
            'last_login' => Helper::getFormattedDateObject($user->last_login, 'datetime')
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => true,
            'delete' =>true,
            'clone' => true,
            'restore' => true,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformUsersDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }
}