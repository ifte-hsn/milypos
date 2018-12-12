<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Transformers\UsersTransformer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function getUserList(Request $request) {
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
        $user = new User();
        $user->activated = 1;
        return view('users.edit', compact('user'));
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
    public function destroy($id = null)
    {
        try {
            $user = User::findOrFail($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Auth::user()->id) {
                // Redirect to the user management page.
                return redirect()->route('users.index')->with('error', __('users/message.error.delete'));
            }

            // Delete the user
            $user->delete();

            // Prepare the success message
            $success = __('users/message.success.delete');

            return redirect()->route('users.index')->with('success', $success);
        }catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }

    }

    /**
     * Export users to csv format
     * @return StreamedResponse
     */
    public function getExportUserCsv () {
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
     */
    public function getRestore($id = null) {
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
     */
    public function postBulkEdit(Request $request)
    {
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


    public function postBulkSave(Request $request)
    {

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
