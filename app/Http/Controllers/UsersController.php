<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\Models\User;

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
}
