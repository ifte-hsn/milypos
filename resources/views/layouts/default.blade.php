<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
        :: {{ $milyPosSettings->site_name }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" type="image/png" href="{{ (isset($milyPosSettings->favicon) && $milyPosSettings->favicon != '') ? asset('uploads/'.$milyPosSettings->favicon) : asset('images/favicon_placeholder.png') }}"/>

    <link rel="stylesheet" href="{{ asset('css/all.css') }}">

    <style nonce="{{ csrf_token() }}">
        @if (($milyPosSettings) && ($milyPosSettings->header_color!=''))
            .main-header .navbar, .main-header .logo {
            background-color: {{ $milyPosSettings->header_color }};
            background: -webkit-linear-gradient(top,  {{ $milyPosSettings->header_color }} 0%,{{ $milyPosSettings->header_color }} 100%);
            background: linear-gradient(to bottom, {{ $milyPosSettings->header_color }} 0%,{{ $milyPosSettings->header_color }} 100%);
            border-color: {{ $milyPosSettings->header_color }};
        }

        .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
            border-left-color: {{ $milyPosSettings->header_color }};
        }

        .btn-primary {
            background-color: {{ $milyPosSettings->header_color }};
            border-color: {{ $milyPosSettings->header_color }};
        }
        @endif
    </style>


    @if (($milyPosSettings) && ($milyPosSettings->custom_css))
        <style>
            {!! $milyPosSettings->show_custom_css() !!}
        </style>
    @endif

    <script nonce="{{ csrf_token() }}">
        window.milypos = {
            settings: {
                "per_page": {{ $milyPosSettings->per_page }}
            }
        };
    </script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
<!-- Site wrapper -->
<div class="wrapper">

    @include('layouts.partials.header')

    <!-- =============================================== -->

    @include('layouts.partials.left-sidebar')

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('title')
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('layouts.partials.notifications')

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.partials.footer')

    @include('layouts.partials.right-sidebar')
</div>
<!-- ./wrapper -->

<div class="modal  modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <form method="post" id="deleteForm" role="form">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="button" class="btn btn-default  pull-left" data-dismiss="modal">{{ __('general.cancel') }}</button>
                    <button type="submit" class="btn btn-outline" id="dataConfirmOK">{{ trans('general.yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/all.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>


@yield('page_scripts')
</body>
</html>
