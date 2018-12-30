@extends('layouts.default')
@section('title')
    @if($role->id)
        {{ __('roles/message.update_role') }}
    @else
        {{ __('roles/message.add_role') }}
    @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
    <li><a href="{{ route('roles.index') }}"><i class="fa fa-th"></i> {{ __('general.roles')  }}</a></li>
    @if($role->id)
        <li class="active">{{ __('general.update_role') }}</li>
    @else
        <li class="active">{{ __('general.add_role') }}</li>
    @endif

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="post" autocomplete="off"
                  action="{{ ($role) ? route('roles.update', ['role'=> $role->id]) : route('role.store') }}"
                  class="form-horizontal form-label-left">
                @csrf
                @if($role->id)
                    @method('PUT')
                @endif

                <div class="box-body">

                    <div class="form-group margin-top {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                            {{ __('general.name') }} {!! (\App\Helpers\Helper::checkIfRequired($role, 'name')) ? '<span class="text-danger">*</span>':'' !!}
                        </label><!-- control-label col-md-3 col-sm-3 col-xs-12 -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12"
                                   placeholder="{{ __('general.name') }}"
                                   value="{{ Input::old('name', $role->name) }}">
                            {!! $errors->first('name', '<span class="alert-msg">:message</span>') !!}
                        </div><!-- .col-md-6 col-sm-6 col-xs-12 -->
                    </div><!-- form-group -->

                    <div style="margin-bottom: 100px"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped permissions-table">

                            <thead>
                            <tr class="title">
                                <th colspan="6"
                                    class="text-center"> {{ ($role->name) ? $role->name: '' }} {{ __('general.permissions') }}</th>
                            </tr>

                            <tr>
                                <th rowspan="2" class="text-center">{{ __('general.module_name') }}</th>
                                <th colspan="5" class="text-center">{{ __('general.permissions') }}</th>
                            </tr>

                            <tr>
                                <th class="text-center">{{ __('general.view') }}</th>
                                <th class="text-center">{{ __('general.add') }}</th>
                                <th class="text-center">{{ __('general.edit') }}</th>
                                <th class="text-center">{{ __('general.delete') }}</th>
                                <th class="text-center">{{ __('general.miscellaneous') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ __('general.user') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="view_user">
                                                <input name="View User" id="view_user"
                                                       type="checkbox" {{ (old('View User', $role->hasPermissionTo('View User'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- read -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="add_user">
                                                <input name="Add User" id="add_user"
                                                       type="checkbox" {{ (old('Add User', $role->hasPermissionTo('Add User'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Create -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="edit_user">
                                                <input name="Edit User" id="edit_user"
                                                       type="checkbox" {{ (old('Edit User', $role->hasPermissionTo('Edit User'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->


                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="delete_user">
                                                <input name="Delete User" id="delete_user"
                                                       type="checkbox" {{ (old('Delete User', $role->hasPermissionTo('Delete User'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->

                                    <td>
                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="restore_user" class="label-padding">
                                                    <input name="Restore User" id="restore_user"
                                                           type="checkbox" {{ (old('Restore User', $role->hasPermissionTo('Restore User'))) == '1' ? ' checked="checked"' : '' }}>
                                                    <strong>{{ __('general.restore') }}</strong>
                                                </label>
                                            </div>
                                        </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="export_user" class="label-padding">
                                                        <input name="Export Users" id="export_user"
                                                               type="checkbox" {{ (old('Export Users', $role->hasPermissionTo('Export Users'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.export') }}</strong>
                                                    </label>
                                                </div>
                                            </span>

                                            <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="bulk_delete_user" class="label-padding">
                                                        <input name="Bulk Delete Users" id="bulk_delete"
                                                               type="checkbox" {{ (old('Bulk Delete Users', $role->hasPermissionTo('Bulk Delete Users'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                                    </label>
                                                </div>
                                            </span>
                                    </td><!-- Update -->
                                </tr> <!-- user module -->


                                <tr>
                                    <td>
                                        <strong>{{ __('general.category') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="view_category">
                                                <input name="View Category" id="view_category"
                                                       type="checkbox" {{ (old('View Category', $role->hasPermissionTo('View Category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- read -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="add_category">
                                                <input name="Add Category" id="add_category"
                                                       type="checkbox" {{ (old('Add Category', $role->hasPermissionTo('Add Category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Create -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="edit_category">
                                                <input name="Edit Category" id="edit_category"
                                                       type="checkbox" {{ (old('Edit Category', $role->hasPermissionTo('Edit Category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->


                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="delete_category">
                                                <input name="Delete Category" id="delete_category"
                                                       type="checkbox" {{ (old('Delete Category', $role->hasPermissionTo('Delete Category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->

                                    <td>

                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="restore_category" class="label-padding">
                                                    <input name="Restore Category" id="restore_category"
                                                           type="checkbox" {{ (old('Restore Category', $role->hasPermissionTo('Restore Category'))) == '1' ? ' checked="checked"' : '' }}>
                                                    <strong>{{ __('general.restore') }}</strong>
                                                </label>
                                            </div>
                                        </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="export_category" class="label-padding">
                                                        <input name="Export Categories" id="export_category"
                                                               type="checkbox" {{ (old('Export Categories', $role->hasPermissionTo('Export Categories'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.export') }}</strong>
                                                    </label>
                                                </div>
                                            </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="bulk_delete_category" class="label-padding">
                                                        <input name="Bulk Delete Categories" id="bulk_delete_category"
                                                               type="checkbox" {{ (old('Bulk Delete Categories', $role->hasPermissionTo('Bulk Delete Categories'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                                    </label>
                                                </div>
                                            </span>
                                    </td><!-- Update -->
                                </tr> <!-- category module -->

                               <tr>
                                   <td>
                                       <strong>{{ __('general.role') }}</strong>
                                   </td>

                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="view_role">
                                               <input name="View Role" id="view_role"
                                                      type="checkbox" {{ (old('View Role', $role->hasPermissionTo('View Role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- read -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="add_role">
                                               <input name="Add Role" id="add_role"
                                                      type="checkbox" {{ (old('Add Role', $role->hasPermissionTo('Add Role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- add -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="edit_role">
                                               <input name="Edit Role" id="edit_role"
                                                      type="checkbox" {{ (old('Edit Role', $role->hasPermissionTo('Edit Role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- edit -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="delete_role">
                                               <input name="Delete Role" id="delete_role"
                                                      type="checkbox" {{ (old('Delete Role', $role->hasPermissionTo('Delete Role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- delete -->


                                   <td>
                                       <span style="display:inline-block;">
                                           <div class="checkbox icheck">
                                               <label for="restore_role" class="label-padding">
                                                   <input name="Restore Role" id="restore_role"
                                                          type="checkbox" {{ (old('Restore Role', $role->hasPermissionTo('Restore Role'))) == '1' ? ' checked="checked"' : '' }}>
                                                   <strong>{{ __('general.restore_role') }}</strong>
                                               </label>
                                           </div>
                                       </span>
                                   </td><!-- read -->
                               </tr>
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->

                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-lg btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
                            </button>
                        </div><!-- col-md-4 col-md-offset-6 -->
                    </div><!-- .row -->
                </div><!-- box-footer -->
            </form><!-- form-horizontal form-label-left -->
        </div>
    </div><!-- box-primary -->
@endsection

@section('page_scripts')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endsection