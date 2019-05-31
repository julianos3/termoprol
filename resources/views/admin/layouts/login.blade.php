<!doctype html>
<html class="fixed">
<head>

    <title>{{ config('app.name') }}</title>
    <!-- Basic -->
    <meta charset="UTF-8">

    <meta name="keywords" content="Agência S3"/>
    <meta name="description" content="Agência S3 CMS">
    <meta name="author" content="agencias3.com.br">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/font-awesome/css/font-awesome.css') }}"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.css') }}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme-custom.css') }}"/>

    <!-- Head Libs -->
    <script src="{{ asset('assets/admin/vendor/modernizr/modernizr.js') }}"></script>
</head>
<body>

@yield('content')

</body>
</html>