<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Transformers\WarehouseTransformer;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('warehouse.view', Warehouse::class);
        return view('warehouses.index');
    }

    public function getWarehouseList(Request $request) {
        $this->authorize('warehouse.view', Warehouse::class);

        $warehouse = Warehouse::select(['*']);

        if(($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $warehouse = $warehouse->GetDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $warehouse = $warehouse->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);


        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'name', 'email', 'phone'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'name';
                $warehouse = $warehouse->orderBy($sort, $order);
                break;
        }

        $total = $warehouse->count();
        $warehouse = $warehouse->skip($offset)->take($limit)->get();
        return (new WarehouseTransformer)->transformWarehouses($warehouse, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('warehouse.add', User::class);
        $warehouse = new Warehouse();
        $roles = DB::table('roles')->get();
        $user = User::all();

        return view('warehouses.edit', compact('warehouse','roles', 'user'));
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
        //
    }
}
