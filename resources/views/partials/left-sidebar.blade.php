<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!}>
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
                    'delete_user',
                    'add_client',
                    'view_client',
                    'edit_client',
                    'delete_client',
                    'restore_client',
                    'bulk_delete_clients',
                    'export_clients'
                ]) || Auth::user()->hasRole('Super Admin')
            )

            <li class="treeview{{ (Request::is('users*') || Request::is('clients*') ? ' active' : '') }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{{ __('menu.users') }}</span>

                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>


                <ul class="treeview-menu">
                    @if (Auth::user()->hasAnyPermission(
                    [
                        'view_user',
                        'add_user',
                        'edit_user',
                        'delete_user',
                    ]) || Auth::user()->hasRole('Super Admin'))
                    <li {!! (Request::is('users*') ? 'class="active"':'') !!}>
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ __('menu.staff') }}</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasAnyPermission(
                    [
                        'add_client',
                        'view_client',
                        'edit_client',
                        'delete_client',
                        'restore_client',
                        'bulk_delete_clients',
                        'export_clients'
                    ]) || Auth::user()->hasRole('Super Admin'))
                    <li {!! (Request::is('clients*') ? 'class="active"':'') !!}>
                        <a href="{{ route('clients.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ __('menu.clients') }}</span>
                        </a>
                    </li>
                @endif
                </ul>
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
            <li {!! (Request::is('roles*') ? 'class="active"':'') !!}>
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
                <li {!! (Request::is('categories*') ? 'class="active"':'') !!}>
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
                <li {!! (Request::is('products*') ? 'class="active"':'') !!}>
                    <a href="{{ route('products.index') }}">
                        <i class="fa fa-product-hunt"></i>
                        <span>{{ __('menu.products') }}</span>
                    </a>
                </li>
            @endif

            <li class="treeview{{ (Request::is('sales*') ? ' active':'') }}">
                <a href="#">
                    <i class="fa fa-list-ul"></i>
                    <span>{{ __('general.sales') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li {!! (Request::is('sales/manage*') ? 'class="active"':'') !!}>
                        <a href="{{ route('sales.index') }}"><i class="fa fa-circle-o"></i> {{ __('general.manage_sales') }}</a>
                    </li>
                    <li {!! (Request::is('sales/create*') ? 'class="active"':'') !!}>
                        <a href="{{ route('sales.create') }}"><i class="fa fa-circle-o"></i> {{ __('general.create_sale') }}</a>
                    </li>
                    <li {!! (Request::is('sales/report*') ? 'class="active"':'') !!}>
                        <a href="{{ route('sales.report') }}"><i class="fa fa-circle-o"></i> {{ __('general.sales_report') }}</a>
                    </li>
                </ul>
            </li>

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