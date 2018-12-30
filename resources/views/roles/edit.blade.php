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

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped reports-table">

                            <thead>
                                <tr>
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
                                        <strong>{{ __('general.users') }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input name="View User" id="read_user" type="checkbox">
                                            </label>
                                        </div>
                                    </td><!-- read -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input name="Create User" id="create_user" type="checkbox">
                                            </label>
                                        </div>
                                    </td><!-- Create -->

                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input name="Edit User" id="update_user" type="checkbox">
                                            </label>
                                        </div>
                                    </td><!-- Update -->


                                    <td class="text-center">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input name="Delete User" id="delete_user" type="checkbox">
                                            </label>
                                        </div>
                                    </td><!-- Update -->

                                    <td>
                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="export_user" class="padding05">
                                                    <input name="Export Users" id="export_user" type="checkbox"> <strong>{{ __('general.export') }}</strong>
                                                </label>
                                            </div>
                                        </span>

                                        <span style="display:inline-block;">
                                            <div class="checkbox icheck">
                                                <label for="bulk_delete" class="padding05">
                                                    <input name="Bulk Delete" id="bulk_delete" type="checkbox"> <strong>{{ __('general.bulk_checkin_and_delete') }}</strong>
                                                </label>
                                            </div>
                                        </span>
                                    </td><!-- Update -->
                                </tr> <!-- user module -->
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->

                </div><!-- .box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-6">
                            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> {{ __('general.save') }}
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