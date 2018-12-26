<?php
return array(
    'no_category_selected'                        => 'No Category selected',
    'category_exists'                             => 'Category already exists.',
    'category_not_found'                          => 'Category [:id] does not exists.',
    'category_email_required'                     => 'Category email address required.',
    'category_password_required'                  => 'The password is required.',
    'insufficient_permissions'                => 'Insufficient Permissions.',
    'category_deleted_warning'                    => 'This category has been deleted. You will have to restore this category to edit them.',
    'do_not_have_permission_to_see_category_list' => 'Sorry! You do not have permission to see category list!',
    'add_category'                                => 'Add New Category',
    'update_category'                             => 'Update Category',
    'bulk_delete_warning'                     => 'You are about to delete the  :count category(s) listed below. Super admin names are highlighted in red.',

    'success' => array(
        'create'                => 'Category was successfully created.',
        'update'                => 'Category was successfully updated.',
        'update_bulk'           => 'Categories were successfully updated!',
        'delete'                => 'Category was successfully deleted.',
        'deactivated'           => 'Category was successfully deactivated.',
        'activated'             => 'Category was successfully activated.',
        'restored'              => 'Category was successfully restored.',
        'import'                => 'Categories imported successfully.',
        'selected_category_deleted' => 'Your selected categories have been deleted.'
    ),

    'error' => array(
        'create'             => 'There was an issue creating the category. Please try again.',
        'update'             => 'There was an issue updating the category. Please try again.',
        'delete'             => 'There was an issue deleting the category. Please try again.',
        'activate'           => 'There was an issue activating the category. Please try again.',
        'import'             => 'There was an issue importing categories. Please try again.',
        'could_not_restore'  => 'Category could not be restored.',
        'delete_own_account' => 'Sorry!! You can not delete your own account.',
        'delete_super_admin' => 'You are not allowed to delete Super Admin category',
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