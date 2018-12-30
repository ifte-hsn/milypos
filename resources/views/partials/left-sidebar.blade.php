<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li>
                <a href="{{ route('home')  }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __('menu.dashboard') }}</span>
                </a>
            </li>

            {{-- Display user menu if user have any of the following permission--}}
            @if (Auth::user()->hasAnyPermission(
                [
                    'View User',
                    'Create User',
                    'Update User',
                    'Delete User'
                ]) || Auth::user()->hasRole('Super Admin')
            )

            <li>
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-group"></i>
                    <span>{{ __('menu.users') }}</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-shield"></i>
                    <span>{{ __('menu.roles') }}</span>
                </a>
            </li>

            @if (Auth::user()->hasAnyPermission(
                [
                    'Create Category',
                    'Read Category',
                    'Update Category',
                    'Delete Category'
                ]) || Auth::user()->hasRole('Super Admin')
            )
                <li>
                    <a href="{{ route('category.index') }}">
                        <i class="fa fa-th"></i>
                        <span>{{ __('menu.categories') }}</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->can('Update Settings'))
            <li>
                <a href="{{ route('settings.index') }}">
                    <i class="fa fa-cogs"></i>
                    <span>{{ __('menu.settings') }}</span>
                </a>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>