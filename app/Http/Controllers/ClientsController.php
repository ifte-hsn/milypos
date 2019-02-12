<?php

namespace App\Http\Controllers;

use File;
use Input;
use Image;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Transformers\ClientsTransformer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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


        $clients = Client::select(['*']);

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
                    'created_at', 'last_login', 'phone', 'address', 'city', 'state', 'zip', 'id', 'dob'
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
            'email'                   => 'required|email|unique:clients',
            'country_id'              => 'nullable|integer|exists:countries,id',
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

        if($request->has('dob') && $request->input('dob') !='') {
            $originalDate = $request->input('dob');
            $newDate = date("Y-m-d", strtotime($originalDate));
            $client->dob = $newDate;
        }


        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_slug($client->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
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

        $request->validate([
            'first_name'              => 'required|string|min:1',
            'country_id' => 'nullable|integer|exists:countries,id',
        ]);

        try {
            $client = Client::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clients.index')
                ->with('error', __('clients/message.client_not_found', compact('id')));
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


        if($request->has('dob') && $request->input('dob') !='') {
            $originalDate = $request->input('dob');
            $newDate = date("Y-m-d", strtotime($originalDate));
            $client->dob = $newDate;
        }

        if ($request->file('image')) {

            // First we will delete the file
            $path = public_path('uploads/avatars/'.$client->image);
            File::delete($path);

            // Now its time to save new image
            $image = $request->file('image');
            $file_name = str_slug($client->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);

            $client->image = $file_name;
        }

        // Was the client updated?
        if ($client->save()) {
            $success = __('clients/message.success.update');
            // Redirect to the client page
            return redirect()->route('clients.index')->with('success', $success);
        }

        return redirect()->back()->withInput()->withErrors($client->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('delete_client', Client::class);

        $client = Client::findOrFail($id);

        try {
            $client = Client::findOrFail($id);
            $client->delete();
            // Prepare the success message
            $success = __('clients/message.success.delete');

            return redirect()->route('clients.index')->with('success', $success);
        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('clients/message.client_not_found', compact('id'));
            // Redirect to the client management page
            return redirect()->route('clients.index')->with('error', $error);
        }
    }

    /**
     * Restore deleted client
     *
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRestore($id = null)
    {
        $this->authorize('restore_client', Client::class);

        if(!$client = Client::onlyTrashed()->find($id)) {
            return redirect()->route('clients.index')->with('error', __('clients/message.client_not_found', ['id'=>$id]));
        }

        // Restore the client
        if ($client->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('clients.index')->with('success', __('clients/message.success.restored'));
        }

        return redirect()->route('clients.index')->with('error', __('clients/message.error.could_not_restore'));
    }


    /**
     * Process bulk edit button submission
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkEdit(Request $request)
    {
        $this->authorize('bulk_delete_clients', Client::class);


        if ($request->has('ids') && (count($request->input('ids')) > 0)) {
            $client_raw_array = array_keys(Input::get('ids'));

            $clients = Client::whereIn('id', $client_raw_array)->get();

            if($request->input('bulk_actions') == 'edit') {
                return view('clients.bulk-edit', compact('clients'));
            }
            return view('clients.confirm-bulk-delete',compact('clients'));
        }

        return redirect()->back()->with('error', 'clients/message.no_clients_selected');
    }


    /**
     * Save posted data by bulkEdit form
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkSave(Request $request)
    {
        $this->authorize('bulk_delete_clients', Client::class);

        if (!$request->has('ids') || count($request->input('ids')) == 0 ) {

            return redirect()->route('clients.index')->with('error', __('clients/message.no_user_selected'));
        } else {
            $user_raw_array = Input::get('ids');



            $clients = Client::whereIn('id', $user_raw_array)->get();

            foreach ($clients as $user) {
                $user->delete();
            }

            return redirect()->route('clients.index')->with('success', __('clients/message.success.selected_client_deleted'));
        }
    }

    /**
     * @return StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportAsCsv() {
        $this->authorize('export_clients', Client::class);

        $response = new StreamedResponse(function() {
            // Open output steam
            $handle = fopen('php://output', 'w');
            Client::orderBy('created_at', 'desc')->chunk(500, function ($clients) use ($handle) {
                $headers = [
                    // strtolower to prevent Excel from trying to open it as a SYSLK file
                    strtolower(__('general.id')),
                    __('general.name'),
                    __('general.email'),
                    __('general.sex'),
                    __('general.date_of_birth'),
                    __('general.phone'),
                    __('general.address'),
                    __('general.city'),
                    __('general.state'),
                    __('general.zip'),
                    __('general.shopping'),
                    __('general.last_purchase'),
                ];

                fputcsv($handle, $headers);

                foreach ($clients as $client) {


                    $values = [
                        $client->id,
                        $client->fullName,
                        $client->email,
                        $client->sex,
                        $client->dob,
                        $client->phone,
                        $client->address,
                        $client->city,
                        $client->state,
                        $client->zip,
                        $client->shopping,
                        $client->last_purchase,
                    ];

                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="clients-'.date('Y-m-d-his').'.csv"',
        ]);


        return $response;
    }
}
