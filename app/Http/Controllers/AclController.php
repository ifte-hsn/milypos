<?php

namespace App\Http\Controllers;

use App\Http\Transformers\RolesTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Role;

class AclController extends Controller
{

    /**
     * Show role index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function roleIndex() {
        $this->authorize('Read Role', \Spatie\Permission\Models\Role::class);
        return view('roles.index');
    }


    /**
     * Get list of roles from database
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRoleList(Request $request) {
        $this->authorize('Read Role', \Spatie\Permission\Models\Role::class);

        $roles = Role::select([
            'roles.id',
            'roles.name',
            'roles.deleted_at',
            'roles.created_at'
        ]);

        if ($request->has('deleted') && $request->input('deleted') == 'true') {
            $roles = $roles->getDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $roles = $roles->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 20);

        switch ($request->input('sort')) {
            default:
                $allowed_columns = ['name', 'id'];
                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';

                $roles = $roles->orderBy($sort, $order);
                break;
        }


        $total = $roles->count();
        $roles = $roles->skip($offset)->take($limit)->get();

        return (new RolesTransformer)->transformRoles($roles, $total);
    }

    public function getRoleRestore($id = null) {
        $this->authorize('Create Role', \Spatie\Permission\Models\Role::class);

        if(!$role = Role::onlyTrashed()->find($id)) {
            return redirect()->route('roles.index')->with('error', __('roles/message.role_not_found', ['id'=>$id]));
        }

        if ($role->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('roles.index')->with('success', __('role/message.success.restored'));
        }

        return redirect()->route('roles.index')->with('error', __('roles/message.add_role/message.error.could_not_restore'));
    }

    public function destroyRole($id) {
        $this->authorize('Delete Role', \Spatie\Permission\Models\Role::class);

        try {
            $role = Role::findOrFail($id);
            $role->delete();

            $success = __('roles/message.success.delete');
            return redirect()->route('roles.index')->with('success', $success);

        }catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('roles/message.category_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('roles.index')->with('error', $error);
        }
    }
}
