<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li>
                <a href="{{ url('/') }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('menu.dashboard') }}</span>
                </a>
            </li>

            {{-- Display user menu if user have any of the following permission--}}
            @if(Auth::user()->hasAnyPermission(
                [
                    'Create User',
                    'Read User',
                    'Update User',
                    'Delete User'
                ]) || Auth::user()->hasRole('Super Admin')
            )

            <li>
                <a href="{{ url('/users') }}">
                    <i class="fa fa-group"></i>
                    <span>{{ __('menu.users') }}</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{ url('/settings') }}">
                    <i class="fa fa-cogs"></i>
                    <span>{{ __('menu.settings') }}</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>