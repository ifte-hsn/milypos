<?php

namespace App\Http\Controllers;

use App\Http\Transformers\WarehouseTransformer;
use App\Models\Warehouse;
use Illuminate\Http\Request;

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
        $this->authorize('view_warehouse', Warehouse::class);
        return view('warehouses.index');
    }

    public function getWarehouseList(Request $request) {
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
//
//        $response = [
//            'total'=> '1',
//            'rows' => [
//                'id' => '1',
//                'code' => '222',
//                'name' => 'Warehouse 2',
//                'phone' => '22-22-2',
//                'email' => 'test@emxample.com',
//                'address' => 'Dhaka, Bangladesh',
//                'contact_person' => [
//                    'name' => 'Iftekhar Hossain',
//                    'email' => 'ifte.hsn@gmail.com',
//                    'phone' => '0939444224',
//                    'role' => 'Warehouse Manager',
//                    'slug' => 'http://something.com'
//                ]
//            ]
//        ];
//
//        return json_encode($response);
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
        //
    }
}
