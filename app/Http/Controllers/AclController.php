<?php

namespace App\Http\Controllers;

use App\Http\Transformers\RolesTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Redirect;

class AclController extends Controller
{

    /**
     * Show role index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_role', Role::class);
        return view('roles.index');
    }


    /**
     * Show Role form for role creation
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_role', Role::class);
        $role = new Role();

        return view('roles.edit', compact('role'));
    }

    public function store(Request $request)
    {
        $this->authorize('add_role', Role::class);

        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $parmissions_list = array(
            'add_user',
            'view_user',
            'edit_user',
            'delete_user',
            'restore_user',
            'bulk_delete_users',
            'export_users',
            'add_category',
            'view_category',
            'edit_category',
            'delete_category',
            'restore_category',
            'export_categories',
            'bulk_delete_categories',
            'add_role',
            'view_role',
            'edit_role',
            'delete_role',
            'restore_role',
            'update_settings'
        );

        $new_permissions = array();

        foreach ($parmissions_list as $permission) {
            if ($request->input($permission) == null)
                continue;
            $new_permissions[$permission] = $permission;
        }

        $role = new Role();
        $role->name = $request->input('name');

        $role->save();

        $role->syncPermissions($new_permissions);
        $success = __('roles/message.success.update');
        return redirect()->route('roles.index')->with('success', $success);
        

        $role = Role::findById($id);

        $role->name = $request->input('name');

        if ($role->save()) {

            if ($role->syncPermissions($new_permissions)) {
                $success = __('roles/message.success.update');
                return redirect()->route('roles.index')->with('success', $success);
            }

            $error = __('roles/message.error.update');
            return redirect()->route('roles.index')->with('error', $error);

        }

        $error = __('roles/message.error.update');
        return redirect()->route('roles.index')->with('error', $error);

    }

    /**
     * @param $id
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('edit_role', Role::class);

        $role = Role::findById($id);

        if ($role->name === 'Super Admin') {
            $error = __('roles/message.error.roleIndex');
            return redirect()->back()->with('error', $error);
        }

        return Redirect::route('roles.edit', ['id' => $id]);
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit_role', Role::class);

        if ($role = Role::findOrFail($id)) {
            return view('roles.edit', compact('role'));
        }

        $error = __('roles/message.role_not_found', compact('id'));
        return redirect()->route('roles.index')->with('error', $error);
    }

    /**
     * Update Role
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit_role', Role::class);

        $parmissions_list = array(
            'add_user',
            'view_user',
            'edit_user',
            'delete_user',
            'restore_user',
            'bulk_delete_users',
            'export_users',
            'add_category',
            'view_category',
            'edit_category',
            'delete_category',
            'restore_category',
            'export_categories',
            'bulk_delete_categories',
            'add_role',
            'view_role',
            'edit_role',
            'delete_role',
            'restore_role',
            'update_settings'
        );

        $new_permissions = array();

        foreach ($parmissions_list as $permission) {
            if ($request->input($permission) == null)
                continue;
            $new_permissions[$permission] = $permission;
        }


        $role = Role::findById($id);

        $role->name = $request->input('name');

        if ($role->save()) {

            if ($role->syncPermissions($new_permissions)) {
                $success = __('roles/message.success.update');
                return redirect()->route('roles.index')->with('success', $success);
            }

            $error = __('roles/message.error.update');
            return redirect()->route('roles.index')->with('error', $error);

        }

        $error = __('roles/message.error.update');
        return redirect()->route('roles.index')->with('error', $error);
    }

    /**
     * Delete Role
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('delete_role', Role::class);

        try {
            $role = Role::findOrFail($id);

            if ($role->name === 'Super Admin') {
                $error = __('roles/message.error.delete_super_admin');
                return redirect()->route('roles.index')->with('error', $error);
            }

            $role->delete();

            $success = __('roles/message.success.delete');
            return redirect()->route('roles.index')->with('success', $success);

        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('roles/message.category_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('roles.index')->with('error', $error);
        }
    }


    /**
     * Get list of roles from database
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRoleList(Request $request)
    {
        $this->authorize('view_role', Role::class);

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


    /**
     * Method for Restore Roles
     *
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRoleRestore($id = null)
    {
        $this->authorize('restore_role', Role::class);

        if (!$role = Role::onlyTrashed()->find($id)) {
            return redirect()->route('roles.index')->with('error', __('roles/message.role_not_found', ['id' => $id]));
        }

        if ($role->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('roles.index')->with('success', __('role/message.success.restored'));
        }

        return redirect()->route('roles.index')->with('error', __('roles/message.add_role/message.error.could_not_restore'));
    }

}
