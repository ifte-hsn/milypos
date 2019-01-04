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

                            <!--****************************-->
                            <!--         USER module        -->
                            <!--****************************-->
                                <tr>
                                    <td>
                                        <strong>{{ __('general.staff') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="view_user">
                                                <input name="view_user" id="view_user"
                                                       type="checkbox" {{ (old('view_user', $role->hasPermissionTo('view_user'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- read -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="add_user">
                                                <input name="add_user" id="add_user"
                                                       type="checkbox" {{ (old('add_user', $role->hasPermissionTo('add_user'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Create -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="edit_user">
                                                <input name="edit_user" id="edit_user"
                                                       type="checkbox" {{ (old('edit_user', $role->hasPermissionTo('edit_user'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->


                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="delete_user">
                                                <input name="delete_user" id="delete_user"
                                                       type="checkbox" {{ (old('delete_user', $role->hasPermissionTo('delete_user'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->

                                    <td>
                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="restore_user" class="label-padding">
                                                    <input name="restore_user" id="restore_user"
                                                           type="checkbox" {{ (old('restore_user', $role->hasPermissionTo('restore_user'))) == '1' ? ' checked="checked"' : '' }}>
                                                    <strong>{{ __('general.restore') }}</strong>
                                                </label>
                                            </div>
                                        </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="export_user" class="label-padding">
                                                        <input name="export_users" id="export_user"
                                                               type="checkbox" {{ (old('export_users', $role->hasPermissionTo('export_users'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.export') }}</strong>
                                                    </label>
                                                </div>
                                            </span>

                                            <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="bulk_delete_user" class="label-padding">
                                                        <input name="bulk_delete_users" id="bulk_delete"
                                                               type="checkbox" {{ (old('bulk_delete_users', $role->hasPermissionTo('bulk_delete_users'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                                    </label>
                                                </div>
                                            </span>
                                    </td><!-- Update -->
                                </tr> <!-- user module -->




                            <!--*************************-->
                            <!--      Clients module     -->
                            <!--*************************-->
                            <tr>
                                <td>
                                    <strong>{{ __('general.clients') }}</strong>
                                </td>

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="view_client">
                                            <input name="view_client" id="view_client"
                                                   type="checkbox" {{ (old('view_client', $role->hasPermissionTo('view_client'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- read -->

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="add_client">
                                            <input name="add_client" id="add_client"
                                                   type="checkbox" {{ (old('add_client', $role->hasPermissionTo('add_client'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Create -->

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="edit_client">
                                            <input name="edit_client" id="edit_client"
                                                   type="checkbox" {{ (old('edit_client', $role->hasPermissionTo('edit_client'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Update -->


                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="delete_client">
                                            <input name="delete_client" id="delete_client"
                                                   type="checkbox" {{ (old('delete_client', $role->hasPermissionTo('delete_client'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Update -->

                                <td>
                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="restore_client" class="label-padding">
                                                <input name="restore_client" id="restore_client"
                                                       type="checkbox" {{ (old('restore_client', $role->hasPermissionTo('restore_client'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.restore') }}</strong>
                                            </label>
                                        </div>
                                    </span>

                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="export_clients" class="label-padding">
                                                <input name="export_clients" id="export_clients"
                                                       type="checkbox" {{ (old('export_clients', $role->hasPermissionTo('export_clients'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.export') }}</strong>
                                            </label>
                                        </div>
                                    </span>

                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="bulk_delete_clients" class="label-padding">
                                                <input name="bulk_delete_clients" id="bulk_delete"
                                                       type="checkbox" {{ (old('bulk_delete_clients', $role->hasPermissionTo('bulk_delete_clients'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                            </label>
                                        </div>
                                    </span>
                                </td><!-- Update -->
                            </tr> <!-- clients module -->


                            <!--*************************-->
                            <!--      Products module    -->
                            <!--*************************-->
                            <tr>
                                <td>
                                    <strong>{{ __('general.products') }}</strong>
                                </td>

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="view_product">
                                            <input name="view_product" id="view_product"
                                                   type="checkbox" {{ (old('view_product', $role->hasPermissionTo('view_product'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- read -->

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="add_product">
                                            <input name="add_product" id="add_product"
                                                   type="checkbox" {{ (old('add_product', $role->hasPermissionTo('add_product'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Create -->

                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="edit_product">
                                            <input name="edit_product" id="edit_product"
                                                   type="checkbox" {{ (old('edit_product', $role->hasPermissionTo('edit_product'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Update -->


                                <td class="text-center">
                                    <div class="checkbox icheck">
                                        <label for="delete_product">
                                            <input name="delete_product" id="delete_product"
                                                   type="checkbox" {{ (old('delete_product', $role->hasPermissionTo('delete_product'))) == '1' ? ' checked="checked"' : '' }}>
                                        </label>
                                    </div>
                                </td><!-- Update -->

                                <td>
                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="restore_product" class="label-padding">
                                                <input name="restore_product" id="restore_product"
                                                       type="checkbox" {{ (old('restore_product', $role->hasPermissionTo('restore_product'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.restore') }}</strong>
                                            </label>
                                        </div>
                                    </span>

                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="export_products" class="label-padding">
                                                <input name="export_products" id="export_product"
                                                       type="checkbox" {{ (old('export_products', $role->hasPermissionTo('export_products'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.export') }}</strong>
                                            </label>
                                        </div>
                                    </span>

                                    <span style="display:inline-block;">
                                        <div class="checkbox icheck">
                                            <label for="bulk_delete_products" class="label-padding">
                                                <input name="bulk_delete_products" id="bulk_delete_products"
                                                       type="checkbox" {{ (old('bulk_delete_products', $role->hasPermissionTo('bulk_delete_products'))) == '1' ? ' checked="checked"' : '' }}>
                                                <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                            </label>
                                        </div>
                                    </span>
                                </td><!-- Update -->
                            </tr> <!-- clients module -->



                            <!--****************************-->
                            <!--      CATEGORIES module     -->
                            <!--****************************-->

                                <tr>
                                    <td>
                                        <strong>{{ __('general.category') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="view_category">
                                                <input name="view_category" id="view_category"
                                                       type="checkbox" {{ (old('view_category', $role->hasPermissionTo('view_category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- read -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="add_category">
                                                <input name="add_category" id="add_category"
                                                       type="checkbox" {{ (old('add_category', $role->hasPermissionTo('add_category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Create -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="edit_category">
                                                <input name="edit_category" id="edit_category"
                                                       type="checkbox" {{ (old('edit_category', $role->hasPermissionTo('edit_category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->


                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label for="delete_category">
                                                <input name="delete_category" id="delete_category"
                                                       type="checkbox" {{ (old('delete_category', $role->hasPermissionTo('delete_category'))) == '1' ? ' checked="checked"' : '' }}>
                                            </label>
                                        </div>
                                    </td><!-- Update -->

                                    <td>

                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="restore_category" class="label-padding">
                                                    <input name="restore_category" id="restore_category"
                                                           type="checkbox" {{ (old('restore_category', $role->hasPermissionTo('restore_category'))) == '1' ? ' checked="checked"' : '' }}>
                                                    <strong>{{ __('general.restore') }}</strong>
                                                </label>
                                            </div>
                                        </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="export_category" class="label-padding">
                                                        <input name="export_categories" id="export_category"
                                                               type="checkbox" {{ (old('export_categories', $role->hasPermissionTo('export_categories'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.export') }}</strong>
                                                    </label>
                                                </div>
                                            </span>

                                        <span style="display:inline-block;">
                                                <div class="checkbox icheck">
                                                    <label for="bulk_delete_category" class="label-padding">
                                                        <input name="bulk_delete_categories" id="bulk_delete_category"
                                                               type="checkbox" {{ (old('bulk_delete_categories', $role->hasPermissionTo('bulk_delete_categories'))) == '1' ? ' checked="checked"' : '' }}>
                                                        <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                                    </label>
                                                </div>
                                            </span>
                                    </td><!-- Update -->
                                </tr> <!-- category module -->


                            <!--***********************-->
                            <!--      ROLES module     -->
                            <!--***********************-->

                               <tr>
                                   <td>
                                       <strong>{{ __('general.role') }}</strong>
                                   </td>

                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="view_role">
                                               <input name="view_role" id="view_role"
                                                      type="checkbox" {{ (old('view_role', $role->hasPermissionTo('view_role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- read -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="add_role">
                                               <input name="add_role" id="add_role"
                                                      type="checkbox" {{ (old('add_role', $role->hasPermissionTo('add_role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- add -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="edit_role">
                                               <input name="edit_role" id="edit_role"
                                                      type="checkbox" {{ (old('edit_role', $role->hasPermissionTo('edit_role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- edit -->


                                   <td class="text-center">
                                       <div class="checkbox icheck">
                                           <label for="delete_role">
                                               <input name="delete_role" id="delete_role"
                                                      type="checkbox" {{ (old('delete_role', $role->hasPermissionTo('delete_role'))) == '1' ? ' checked="checked"' : '' }}>
                                           </label>
                                       </div>
                                   </td><!-- delete -->

                                   <td>
                                       <span style="display:inline-block;">
                                           <div class="checkbox icheck">
                                               <label for="restore_role" class="label-padding">
                                                   <input name="restore_role" id="restore_role"
                                                          type="checkbox" {{ (old('restore_role', $role->hasPermissionTo('restore_role'))) == '1' ? ' checked="checked"' : '' }}>
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