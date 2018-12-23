<header class="main-header">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ __('general.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        @if ($milyPosSettings->brand == 'logo_only')

            <a href="{{ route('home') }}">
                @if ($milyPosSettings->logo!='')
                    <img class="navbar-brand-img" src="{{ url('/') }}/uploads/{{ $milyPosSettings->logo }}">
                @endif
            </a>

        @elseif ($milyPosSettings->brand == 'text_only')
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">{{ $milyPosSettings->site_name }}</span>
                </a>
        @elseif(($milyPosSettings->brand == 'text_logo'))
                <a class="logo navbar-brand no-hover" href="{{ route('home') }}">
                    @if ($milyPosSettings->logo!='')
                        <img class="navbar-brand-img" src="{{ url('/') }}/uploads/{{ $milyPosSettings->logo }}">
                    @endif
                    {{ $milyPosSettings->site_name }}
                </a>
        @endif


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if (Auth::check())
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->avatar != null)
                            <img src="{{ url('/') }}/uploads/avatars/{{ $user->avatar }}" class="user-image" alt="User Image">
                        @else
                            <img src="{{ asset('img/avatar-placeholder.png') }}" class="user-image" alt="{{ Auth::user()->fullName }}">
                        @endif
                        <span class="hidden-xs">{{ Auth::user()->first_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">

                            @if(Auth::user()->avatar != null)
                                <img src="{{ url('/') }}/uploads/avatars/{{ $user->avatar }}" class="img-circle" alt="{{ Auth::user()->fullName }}">
                            @else
                                <img src="{{ asset('img/avatar-placeholder.png') }}" class="img-circle" alt="{{ Auth::user()->fullName }}">
                            @endif

                            <p>
                                {{ Auth::user()->full_name }}
                                <small>Member since {!! \App\Helpers\Helper::getFormattedDateObject(Auth::user()->created_at, 'datetime')['formatted'] !!}</small>

                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('users.edit', ['id' => Auth::user()->id ]) }}" class="btn btn-default btn-flat">{{ __('general.edit_profile') }}</a>
                            </div>
                            <div class="pull-right">
                                <form id="logout-form" action="{{ url('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-default btn-flat"> {{ __('general.sign_out') }}</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li><!-- user account menu -->
                @endif
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>