<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Carbon\Carbon;
use DB;
use Input;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Transformers\UsersTransformer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Image;
use File;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Authorize user
        // check if logged in user has the permission to see users data

        $this->authorize('Read User', User::class);
        return view('users.index');
    }

    /**
     * Return list of users to show in bootstrap table
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getUserList(Request $request) {
        // Authorize user
        // check if logged in user has the permission to see users data
        $this->authorize('Read User', User::class);


        $users = User::select([
            'users.activated',
            'users.address',
            'users.avatar',
            'users.city',
            'users.country_id',
            'users.website',
            'users.created_at',
            'users.deleted_at',
            'users.email',
            'users.first_name',
            'users.last_name',
            'users.id',
            'users.last_login',
            'users.phone',
            'users.state',
            'users.sex',
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
                    'created_at', 'last_login', 'phone', 'address', 'city', 'state', 'zip', 'id'
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {

        // Authorize user
        // check if logged in user has the permission to create new user data
        $this->authorize('Create User', User::class);

        $user = new User();
        $user->activated = 1;

        $roles = DB::table('roles')->get();
        $countries = Country::all();
        return view('users.edit', compact('user', 'roles', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {

        // Authorize user
        // check if logged in user has the permission to create new users data
        $this->authorize('Create User', User::class);

        $request->validate([
            'first_name'              => 'required|string|min:1',
            'email'                   => 'required|email|unique:users',
            'password'                => 'required|min:6',
        ]);


        $user = new User();

        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->activated = $request->activated;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->website = $request->website;
        $user->employee_num = $request->employee_num;
        $user->phone = $request->phone;
        $user->fax = $request->fax;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->sex = $request->sex;
        $user->country_id = $request->country;

        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $file_name = str_slug($user->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);

            $user->avatar = $file_name;
        }

        if ($user->save()) {
            $user->assignRole($request->role);
            return redirect()->route('users.index')->with('success', __('users/message.success.create'));
        } else {
            return redirect()->back()->withInput()->withErrors($user->getErrors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {

        // Authorize user
        // check if logged in user has the permission to update user information data
        $this->authorize('Update User', User::class);


        if($user =  User::findOrFail($id)) {
            $roles = DB::table('roles')->get();
            $countries = Country::all();
            return view('users.edit', compact('user', 'roles', 'countries'));
        }
        $error = __('users/message.user_not_found', compact('id'));
        return redirect()->route('users.index')->with('error', $error);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {

        // Authorize user
        // check if logged in user has the permission to update user information data
        $this->authorize('Update User', User::class);


        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', __('users/message.user_not_found', compact('id')));
        }


        $user->email = $request->email;
        $user->activated = $request->activated;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->website = $request->website;
        $user->employee_num = $request->employee_num;
        $user->phone = $request->phone;
        $user->fax = $request->fax;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->sex = $request->sex;
        $user->country_id = $request->country;


        if ($request->has('password') && $request->password != null) {
            $user->password = bcrypt($request->password);
        }

        if ($request->file('avatar')) {

            // First we will delete the file
            $path = public_path('uploads/avatars/'.$user->avatar);
            File::delete($path);

            // Now its time to save new image
            $image = $request->file('avatar');
            $file_name = str_slug($user->first_name."-".Carbon::now()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);

            Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);

            $user->avatar = $file_name;
        }

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $user->assignRole($request->role);
            $success = __('users/message.success.update');
            // Redirect to the user page
            return redirect()->route('users.index')->with('success', $success);
        }

        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id = null)
    {
        // Authorize user
        // check if logged in user has the permission to delete user data
        $this->authorize('Delete User', User::class);


        try {
            $user = User::findOrFail($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Auth::user()->id) {
                // Redirect to the user management page.
                return redirect()->route('users.index')->with('error', __('users/message.error.delete_own_account'));
            }

            if (!Auth::user()->hasRole('Super Admin') && $user->hasRole('Super Admin')) {
                return redirect()->route('users.index')->with('error', __('users/message.error.delete_super_admin'));
            }

            // Delete the user
            $user->delete();

            // Prepare the success message
            $success = __('users/message.success.delete');

            return redirect()->route('users.index')->with('success', $success);
        }catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }

    }

    /**
     * Export users to csv format
     * @return StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportAsCsv () {

        // Authorize user
        // check if logged in user has the permission to see users data
        $this->authorize('Read User', User::class);


        $response = new StreamedResponse(function() {
            // Open output steam
            $handle = fopen('php://output', 'w');
            User::orderBy('created_at', 'desc')->chunk(500, function ($users) use ($handle) {
                $headers = [
                  // strtolower to prevent Excel from trying to open it as a SYSLK file
                    strtolower(__('general.id')),
                    __('users/table.name'),
                    __('general.email'),
                    __('general.activated'),
                    __('general.created_at'),
                ];

                fputcsv($handle, $headers);

                foreach ($users as $user) {

                    
                    $values = [
                        $user->id,
                        $user->fullName,
                        $user->email,
                        $user->activated,
                        $user->created_at,
                    ];

                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users-'.date('Y-m-d-his').'.csv"',
        ]);
        return $response;
    }

    /**
     * Restore Deleted User
     * @param int $id ID of the user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRestore($id = null) {
        // Authorize user
        // check if logged in user has the permission to restore user
        // Any user with permission "Create User" can restore data.
        $this->authorize('Create User', User::class);

        if(!$user = User::onlyTrashed()->find($id)) {
            return redirect()->route('users.index')->with('error', __('users/message.user_not_found', ['id'=>$id]));
        }

        // Restore the user
        if ($user->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('users.index')->with('success', __('users/message.success.restored'));
        }

        return redirect()->route('users.index')->with('error', __('users/message.error.could_not_restore'));
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
        // Authorize user
        // check if logged in user has the permission to update user
        $this->authorize('Update User', User::class);


        if ($request->has('ids') && (count($request->input('ids')) > 0)) {
            $user_raw_array = array_keys(Input::get('ids'));

            $users = User::whereIn('id', $user_raw_array)->get();

            if($request->input('bulk_actions') == 'edit') {
                return view('users.bulk-edit', compact('users'));
            }
            return view('users.confirm-bulk-delete',compact('users'));
        }

        return redirect()->back()->with('error', 'users/message.no_user_selected');
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
        // Authorize user
        // check if logged in user has the permission to update user
        $this->authorize('Update User', User::class);

        if (!$request->has('ids') || count($request->input('ids')) == 0 ) {
            return redirect()->back()->with('error', 'users/message.no_user_selected');
        } else {
            $user_raw_array = Input::get('ids');


            if (($key = array_search(Auth::user()->id, $user_raw_array)) !== false) {
                unset($user_raw_array[$key]);
            }

            $users = User::whereIn('id', $user_raw_array)->get();

            foreach ($users as $user) {
                $user->delete();
            }

            return redirect()->route('users.index')->with('success', __('users/message.success.selected_user_deleted'));
        }
    }
}
