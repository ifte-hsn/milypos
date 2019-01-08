<?php

namespace App\Http\Transformers;

use Auth;
use App\Models\Client;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Collection;

class ClientsTransformer
{

    public function transformClients(Collection $clients, $total)
    {
        $array = array();
        foreach ($clients as $client) {
            $array[] = self::transformClient($client);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
    public function transformClient(Client $client)
    {
        $image = url('/').'/images/avatar-placeholder.png';

        if($client->image) {
            $image = url('/').'/uploads/avatars/'.$client->image;
        }



        $array = [
            'id' => (int) $client->id,
            'name'=> $client->fullName,
            'phone' => ($client->phone) ? e($client->phone) : null,
            'address' => ($client->address) ? e($client->address) : null,
            'city' => ($client->city) ? e($client->city) : null,
            'state' => ($client->state) ? e($client->state) : null,
            'country' => ($client->country) ? e($client->country->name) : null,
            'zip' => ($client->zip) ? e($client->zip) : null,
            'email' => ($client->email) ? e($client->email) : null,
            'created_at' => Helper::getFormattedDateObject($client->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($client->updated_at, 'datetime'),
            'image' => $image,
            'sex' => ($client->sex) ? $client->sex : '',
            'dob' => ($client->dob) ? Helper::getFormattedDateObject($client->dob, 'datetime') : null,
            'total_purchase' => ($client->total_purchase) ? e($client->total_purchase) : 0,
            'last_purchase' => ($client->last_purchase) ? Helper::getFormattedDateObject($client->last_purchase, 'datetime') : null,
        ];

        // TODO: Implement parmissinon wise actions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('edit_user') && ($client->deleted_at==''))  ? true : false,
            'delete' =>(Auth::user()->can('delete_user') && ($client->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('restore_user') && ($client->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformClientsDatatable($clients) {
        return (new DatatablesTransformer)->transformDatatables($clients);
    }
}