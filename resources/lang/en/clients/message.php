<?php
return array(
    'no_client_selected'                        => 'No clients selected',
    'client_exists'                             => 'User already exists.',
    'client_not_found'                          => 'User [:id] does not exists.',
    'client_email_required'                     => 'User email address required.',
    'client_password_required'                  => 'The password is required.',
    'insufficient_permissions'                => 'Insufficient Permissions.',
    'client_deleted_warning'                    => 'This client has been deleted. You will have to restore this client to edit them.',
    'do_not_have_permission_to_see_client_list' => 'Sorry! You do not have permission to see client list!',
    'add_client'                                => 'Add New User',
    'update_client'                             => 'Update User',
    'bulk_delete_warning'                     => 'You are about to delete the  :count client(s) listed below.',


    'success' => array(
        'create'                => 'User was successfully created.',
        'update'                => 'User was successfully updated.',
        'update_bulk'           => 'Clients were successfully updated!',
        'delete'                => 'User was successfully deleted.',
        'deactivated'           => 'User was successfully deactivated.',
        'activated'             => 'User was successfully activated.',
        'restored'              => 'User was successfully restored.',
        'import'                => 'Clients imported successfully.',
        'selected_client_deleted' => 'Your selected clients have been deleted.'
    ),

    'error' => array(
        'create'             => 'There was an issue creating the client. Please try again.',
        'update'             => 'There was an issue updating the client. Please try again.',
        'delete'             => 'There was an issue deleting the client. Please try again.',
        'activate'           => 'There was an issue activating the client. Please try again.',
        'import'             => 'There was an issue importing clients. Please try again.',
        'could_not_restore'  => 'User could not be restored.',
        'delete_own_account' => 'Sorry!! You can not delete your own account.',
        'delete_super_admin' => 'You are not allowed to delete Super Admin client',
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);