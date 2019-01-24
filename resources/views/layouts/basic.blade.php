<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        {{ ($milyPosSettings) && ($milyPosSettings->site_name) ? $milyPosSettings->site_name : 'Mily POS' }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <link rel="shortcut icon" type="image/png" href="{{ asset('images/'.$milyPosSettings->favicon) }}"/>

    <link rel="stylesheet" href="{{ asset('css/all.css') }}">


    @if (($milyPosSettings) && ($milyPosSettings->header_color))
        <style>
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

        </style>

    @endif


    @if (($milyPosSettings) && ($milyPosSettings->custom_css))
        <style>
            {!! $milyPosSettings->show_custom_css() !!}
        </style>
    @endif

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

@yield('content')

<script src="{{ asset('js/all.js') }}"></script>

{{-- Page Specific Scripts--}}
@yield('page_scripts')
</body>
</html>
