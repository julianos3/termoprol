<!doctype html>
<html class="fixed">
<head>

    <meta charset="UTF-8">

    <title>Agência S3 - {{ config('app.name') }}</title>

    <meta name="keywords" content="Agência S3"/>
    <meta name="description" content="Agência S3 CMS">
    <meta name="author" content="agencias3.com.br">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/font-awesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/elusive-icons/css/elusive-webfont.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/magnific-popup/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-datepicker/css/datepicker3.css') }}"/>

    <!-- galeria de imagem -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/gallery.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/uploadifive.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.css') }}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme-custom.css') }}"/>

    <!-- Head Libs -->
    <script src="{{ asset('assets/admin/vendor/modernizr/modernizr.js') }}"></script>

    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<section class="body">

    @include('admin.layouts.header')

    <div class="inner-wrapper">
        @include('admin.layouts.menu')
        @yield('content')
    </div>

</section>

<!-- Vendor -->
<script src="{{ asset('assets/admin/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/style-switcher/style.switcher.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/magnific-popup/magnific-popup.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
<script src="{{ asset('assets/admin/js/modals.js') }}"></script>

<script src="{{ asset('assets/admin/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css') }}" />

<script src="{{ asset('assets/admin/js/style.switcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/ios7-switch.js') }}"></script>
<script src="{{ asset('assets/admin/js/ativo.js') }}"></script>
<script src="{{ asset('assets/admin/js/lightbox.js') }}"></script>

<link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-datepicker/css/datepicker3.css') }}" />
<script src="{{ asset('assets/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/admin/js/datepicker.js') }}"></script>

<script src="{{ asset('assets/admin/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/admin/ckeditor/ckeditor.js') }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{ asset('assets/admin/js/theme.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{!!  asset('assets/admin/js/theme.init.js') !!}"></script>

@if(isset($config['galery']) && $config['galery'])

    <script src="{{ asset('assets/admin/js/gallery/mediagallery.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gallery/jquery-1.4.3.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gallery/jquery-ui-1.8.6.custom.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gallery/jquery.scrollto.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gallery/gallery.js') }}"></script>
    <script src="{{ asset('assets/admin/js/gallery/jquery.uploadifive.min.js') }}" type="text/javascript"></script>

    <div class="auxGallery" data-timestamp="{{ $timestamp = time() }}" data-token="{{ csrf_token() }}" data-token-2="{{ md5('unique_salt' . $timestamp) }}" data-uploadScript="@if(isset($routeUpload) && $routeUpload != ''){{ $routeUpload }}@endif"></div>
@endif
<script src="{{ asset('assets/admin/js/jquery.maskMoney.js') }}"></script>
<script src="{{ asset('assets/admin/js/admin.js') }}"></script>
</body>
</html>