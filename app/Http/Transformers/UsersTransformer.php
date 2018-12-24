<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Auth;

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
        $avatar = url('/').'/images/avatar-placeholder.png';

        if($user->avatar) {
            $avatar = url('/').'/uploads/avatars/'.$user->avatar;
        }



        $array = [
            'id' => (int) $user->id,
            'name'=> $user->fullName,
            'first_name' => e($user->first_name),
            'last_name' => e($user->last_name),
            'phone' => ($user->phone) ? e($user->phone) : null,
            'address' => ($user->address) ? e($user->address) : null,
            'city' => ($user->city) ? e($user->city) : null,
            'state' => ($user->state) ? e($user->state) : null,
            'country' => ($user->country) ? e($user->country->name) : null,
            'zip' => ($user->zip) ? e($user->zip) : null,
            'email' => ($user->email) ? e($user->email) : null,
            'activated' => ($user->activated) ? e($user->activated) : null,
            'website' => ($user->website) ? $user->website : null,
            'created_at' => Helper::getFormattedDateObject($user->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($user->updated_at, 'datetime'),
            'last_login' => Helper::getFormattedDateObject($user->last_login, 'datetime'),
            'role' => isset($user->getRoleNames()[0])?$user->getRoleNames()[0]:'',
            'avatar' => $avatar,
            'sex' => ($user->sex) ? $user->sex : ''
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('Update User') && ($user->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('Delete User') && ($user->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('Create User') && ($user->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformUsersDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }
}