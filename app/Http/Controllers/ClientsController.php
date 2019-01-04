<?php

namespace App\Http\Controllers;

use App\Http\Transformers\ClientsTransformer;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Image;
use Input;
use Carbon\Carbon;
use File;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_client', Client::class);
        return view('clients.index');
    }

    public function getClientList(Request $request)
    {
        $this->authorize('view_client', Client::class);


        $clients = Client::select([
            'clients.id',
            'clients.first_name',
            'clients.last_name',
            'clients.email',
            'clients.image',
            'clients.sex',
            'clients.phone',
            'clients.address',
            'clients.city',
            'clients.state',
            'clients.zip',
            'clients.country_id',
            'clients.created_at',
            'clients.deleted_at',
            'clients.updated_at',
        ]);

        if(($request->has('deleted')) && ($request->input('deleted') == 'true')) {
            $clients = $clients->GetDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $clients = $clients->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);


        switch ($request->input('sort')) {
            default:
                $allowed_columns = [
                    'last_name', 'first_name', 'email', 'activated',
                    'created_at', 'last_login', 'phone', 'address', 'city', 'state', 'zip', 'id'
                ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'first_name';
                $clients = $clients->orderBy($sort, $order);
                break;
        }

        $total = $clients->count();
        $clients = $clients->skip($offset)->take($limit)->get();
        return (new ClientsTransformer)->transformClients($clients, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_client', Client::class);

        $client = new Client();

        $countries = Country::all();
        return view('clients.edit', compact('client','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('add_client', Client::class);

        $request->validate([
            'first_name'              => 'required|string|min:1',
        ]);


        $client = new Client();

        $client->email = $request->input('email');
        $client->first_name = $request->input('first_name');
        $client->last_name = $request->input('last_name');
        $client->phone = $request->input('phone');
        $client->address = $request->input('address');
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->zip = $request->input('zip');
        $client->sex = $request->input('sex');
        $client->country_id = $request->input('country');

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_slug($client->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);

            $client->image = $file_name;
        }

        if ($client->save()) {
            return redirect()->route('clients.index')->with('success', __('clients/message.success.create'));
        } else {
            return redirect()->back()->withInput()->withErrors($client->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('view_clients', Client::class);

        return Redirect::route('view_clients.edit', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit_client', Client::class);


        if($client =  Client::findOrFail($id)) {
            $countries = Country::all();
            return view('clients.edit', compact('client', 'countries'));
        }
        $error = __('clients/message.client_not_found', compact('id'));
        return redirect()->route('clients.index')->with('error', $error);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit_client', Client::class);


        try {
            $client = Client::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clients.index')
                ->with('error', __('clients/message.user_not_found', compact('id')));
        }


        $client->email = $request->input('email');
        $client->first_name = $request->input('first_name');
        $client->last_name = $request->input('last_name');
        $client->phone = $request->input('phone');
        $client->address = $request->input('address');
        $client->city = $request->input('city');
        $client->state = $request->input('state');
        $client->zip = $request->input('zip');
        $client->sex = $request->input('sex');
        $client->country_id = $request->input('country');




        if ($request->file('image')) {

            // First we will delete the file
            $path = public_path('uploads/avatars/'.$client->image);
            File::delete($path);

            // Now its time to save new image
            $image = $request->file('image');
            $file_name = str_slug($client->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);

            $client->image = $file_name;
        }

        // Was the user updated?
        if ($client->save()) {
            $success = __('clients/message.success.update');
            // Redirect to the user page
            return redirect()->route('clients.index')->with('success', $success);
        }

        return redirect()->back()->withInput()->withErrors($client->getErrors());
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
