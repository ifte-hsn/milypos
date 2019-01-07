<?php
return array(
    'no_sale_selected'                        => 'No sales selected',
    'sale_exists'                             => 'Sale already exists.',
    'sale_not_found'                          => 'Sale [:id] does not exists.',
    'sale_email_required'                     => 'Sale email address required.',
    'sale_password_required'                  => 'The password is required.',
    'insufficient_permissions'                => 'Insufficient Permissions.',
    'sale_deleted_warning'                    => 'This sale has been deleted. You will have to restore this sale to edit them.',
    'do_not_have_permission_to_see_sale_list' => 'Sorry! You do not have permission to see sale list!',
    'add_sale'                                => 'Add New Sale',
    'update_sale'                             => 'Update Sale',
    'bulk_delete_warning'                     => 'You are about to delete the  :count sale(s) listed below. Super admin names are highlighted in red.',


    'success' => array(
        'create'                => 'Sale was successfully created.',
        'update'                => 'Sale was successfully updated.',
        'update_bulk'           => 'Sales were successfully updated!',
        'delete'                => 'Sale was successfully deleted.',
        'deactivated'           => 'Sale was successfully deactivated.',
        'activated'             => 'Sale was successfully activated.',
        'restored'              => 'Sale was successfully restored.',
        'import'                => 'Sales imported successfully.',
        'selected_sale_deleted' => 'Your selected sales have been deleted.'
    ),

    'error' => array(
        'create'             => 'There was an issue creating the sale. Please try again.',
        'update'             => 'There was an issue updating the sale. Please try again.',
        'delete'             => 'There was an issue deleting the sale. Please try again.',
        'activate'           => 'There was an issue activating the sale. Please try again.',
        'import'             => 'There was an issue importing sales. Please try again.',
        'could_not_restore'  => 'Sale could not be restored.',
        'delete_own_account' => 'Sorry!! You can not delete your own account.',
        'delete_super_admin' => 'You are not allowed to delete Super Admin sale',
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