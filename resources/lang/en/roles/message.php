<?php
return array(
    'no_role_selected'                        => 'No Role selected',
    'role_exists'                             => 'Role already exists.',
    'role_not_found'                          => 'Role [:id] does not exists.',
    'insufficient_permissions'                => 'Insufficient Permissions.',
    'role_deleted_warning'                    => 'This role has been deleted. You will have to restore this role to edit them.',
    'do_not_have_permission_to_see_role_list' => 'Sorry! You do not have permission to see role list!',
    'add_role'                                => 'Add New Role',
    'update_role'                             => 'Update Role',
    'bulk_delete_warning'                     => 'You are about to delete the  :count role(s) listed below. Super admin names are highlighted in red.',

    'success' => array(
        'create'                => 'Role was successfully created.',
        'update'                => 'Role was successfully updated.',
        'update_bulk'           => 'Roles were successfully updated!',
        'delete'                => 'Role was successfully deleted.',
        'deactivated'           => 'Role was successfully deactivated.',
        'activated'             => 'Role was successfully activated.',
        'restored'              => 'Role was successfully restored.',
        'import'                => 'Roles imported successfully.',
        'selected_role_deleted' => 'Your selected categories have been deleted.'
    ),

    'error' => array(
        'create'             => 'There was an issue creating the role. Please try again.',
        'update'             => 'There was an issue updating the role. Please try again.',
        'delete'             => 'There was an issue deleting the role. Please try again.',
        'activate'           => 'There was an issue activating the role. Please try again.',
        'import'             => 'There was an issue importing categories. Please try again.',
        'could_not_restore'  => 'Role could not be restored.',
        'delete_super_admin' => 'You are not allowed to delete Super Admin role',
    ),
    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a file type that is not allowed. Allowed file types are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);