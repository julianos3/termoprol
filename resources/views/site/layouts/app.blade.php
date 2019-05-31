@inject("config", "\AgenciaS3\Http\Controllers\Site\ConfigurationController")
<?php
$ativo = Route::getCurrentRoute()->uri();
if (Route::getCurrentRoute()->uri() == 'home' || Route::getCurrentRoute()->uri() == '/') {
	$ativo = "home";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#" lang="{{ app()->getLocale() }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <base href="{{ config('app.url') }}"/>

    <!-- metas -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="author" content="https://www.agencias3.com.br" />
    <meta name="rating" content="general" />
    <meta name="distribution" content="local"/>
    <meta name="Robots" content="All"/>
    <meta name="revisit" content="7 day" />
    <meta name="url" content="{{ config('app.url') }}"/>
    <link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('store') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/site/css/reset.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/site/css/estilo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/site/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/site/css/responsive.css') }}" type="text/css">

</head>
<body class="def-100 relative">
<div class="fixed top-0 left-0 top-fix"></div>
<div class="def-100 false-header"></div>

@include('site.layouts.header')
@yield('content')
@include('site.layouts.footer')

<!-- JS -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/cycle.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/timeline.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/plugins/lightbox/html5lightbox.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/plugins/slick/slick.js.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/slick/scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/site/js/plugins/masked.js') }}"></script>

</body>
</html>