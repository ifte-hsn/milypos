@extends('layouts.basic')

@section('content')
    <div class="login-box">

        @if (($milyPosSettings) && ($milyPosSettings->logo!=''))
            <div class="login-logo">
                <img src="{{ url('/') }}/uploads/{{ $milyPosSettings->logo }}">
            </div>
            <!-- /.login-logo -->
        @endif
        <div class="login-box-body">

            <p class="login-box-msg">{{ __('general.login_prompt') }}</p>


            <!-- Notifications -->
            @include('layouts.partials.notifications')


            <form action="{{ url('/login') }}" method="post" autocomplete="false">
            @csrf
            <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
                <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
                <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />


                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="{{ __('general.email')  }}" name="email" value="{{ old('email') }}" autocomplete="off" autofocus>
                    {!! $errors->first('email', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('general.password') }}" required>
                    {!! $errors->first('password', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input name="remember" id="remember" type="checkbox"> {{ __('general.remember') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('general.login') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
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