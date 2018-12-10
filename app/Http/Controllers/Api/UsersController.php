<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\UsersTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::select([
            'users.activated',
            'users.address',
            'users.avatar',
            'users.city',
            'users.country',
            'users.created_at',
            'users.deleted_at',
            'users.email',
            'users.first_name',
            'users.last_name',
            'users.id',
            'users.last_login',
            'users.phone',
            'users.state',
            'users.updated_at'
        ]);

        if(($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $users = $users->GetDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $users = $users->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);

        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'last_name', 'first_name', 'email', 'activated',
                    'created_at', 'last_login', 'phone', 'address', 'city', 'state', 'country', 'zip', 'id'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'first_name';
                $users = $users->orderBy($sort, $order);
                break;
        }

        $total = $users->count();
        $users = $users->skip($offset)->take($limit)->get();
        return (new UsersTransformer)->transformUsers($users, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return response()->json(Helper::formatStandardApiResponse('success', null,  __('users/message.success.delete')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  __('users/message.error.delete')));
    }
}
