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
                    'view_user',
                    'add_user',
                    'edit_user',
                    'delete_user'
                ]) || Auth::user()->hasRole('Super Admin')
            )

            <li>
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-group"></i>
                    <span>{{ __('menu.users') }}</span>
                </a>
            </li>
            @endif


            @if (Auth::user()->hasAnyPermission(
                [
                    'add_role',
                    'view_role',
                    'edit_role',
                    'delete_role',
                    'restore_role'
                ]) || Auth::user()->hasRole('Super Admin')
            )
            <li>
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-shield"></i>
                    <span>{{ __('menu.roles') }}</span>
                </a>
            </li>

            @endif

            @if (Auth::user()->hasAnyPermission(
                [
                    'add_category',
                    'view_category',
                    'edit_category',
                    'delete_category'
                ]) || Auth::user()->hasRole('Super Admin')
            )
                <li>
                    <a href="{{ route('category.index') }}">
                        <i class="fa fa-th"></i>
                        <span>{{ __('menu.categories') }}</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasAnyPermission(
                [
                    'add_product',
                    'view_product',
                    'edit_product',
                    'delete_product'
                ]) || Auth::user()->hasRole('Super Admin')
            )
                <li>
                    <a href="{{ route('products.index') }}">
                        <i class="fa fa-product-hunt"></i>
                        <span>{{ __('menu.products') }}</span>
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