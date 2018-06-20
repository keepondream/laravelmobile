<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('lib/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/respond.min.js') }}"></script>
    <![endif]-->
    <link href="{{ asset('static/h-ui/css/H-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('static/h-ui.admin/css/H-ui.admin.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('static/h-ui.admin/css/style.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/h-ui.admin/skin/default/skin.css') }}" id="skin"/>
    <link href="{{ asset('lib/Hui-iconfont/1.0.8/iconfont.css') }}" rel="stylesheet" type="text/css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ asset('lib/DD_belatedPNG_0.0.8a-min.js') }}"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>@yield('title','后台首页')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>

@yield('content')

<!--_footer -->
<script type="text/javascript" src="{{ asset('lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ asset('static/h-ui/js/H-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<!--_footer -->

@yield('script')

</body>
</html>