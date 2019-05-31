@inject("config", "\AgenciaS3\Http\Controllers\Site\ConfigurationController")
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
    <link rel="stylesheet" href="{{ asset('assets/landing-page/css/reset.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/landing-page/css/estilo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/landing-page/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/landing-page/css/responsive.css') }}" type="text/css">

	<link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,700" rel="stylesheet">
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
</head>
<?php
if (Route::getCurrentRoute()->uri() == 'home' || Route::getCurrentRoute()->uri() == '/') {
    $ativo = "home";
} else {
    $ativo = Route::getCurrentRoute()->uri();
    //dd($ativo);
    $url = explode('/', Route::getCurrentRequest()->url());
    $url = end($url);
}
?>

<body class="def-100 relative">
	<div class="fixed top-0 left-0 fix"></div>
	<header class="def-100 p-top-30 p-bottom-30 absolute z-index-999 top-0 left-0 p-top-1024-10 p-bottom-1024-10">
		<div class="def-center">
			<figure class="f-left main-logo">
				<a href="javascript:void(0);" title="{{ config('app.name') }}">
					<img src="http://www.termoprol.com.br/site/public/images/main-logo.png" title="{{ config('app.name') }}" alt="{{ config('app.name') }}" />
				</a>
			</figure>
			<a class="f-right def-50-px f-none m-top-23 none action-menu display-1024-block" href="javascript:void(0);" title="ABRIR MENU">
				<span class="def-100 def-h-5-px bx-blue-2"></span>
				<span class="def-100 def-h-5-px m-top-5 bx-blue-2"></span>
				<span class="def-100 def-h-5-px m-top-5 bx-blue-2"></span>
			</a>
			<nav class="f-right m-top-20 c-left main-menu display-1024-none w-1024-100 absolute-1024 left-1024-0 top-1024-0 m-top-1024-90">
				<ul class="w-1024-100">
					<li class="w-1024-100">
						<a class="click-and-scroll" data-anchor="home" href="javascript:void(0);" title="HOME">
							Home
						</a>
					</li>
					<li class="w-1024-100">
						<a class="click-and-scroll" data-anchor="service" href="javascript:void(0);" title="SERVIÇO">
							Serviço
						</a>
					</li>
					<li class="w-1024-100">
						<a class="click-and-scroll" data-anchor="contact" href="javascript:void(0);" title="CONTATO">
							Contato
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	@yield('content')

	<footer class="def-100 p-top-1024-30 p-bottom-1024-30" id="contact">
		<div class="def-100 p-top-50 p-bottom-50">
			<div class="def-center">
				<div class="def-100 t-align-c">
					<div class="display-inline-block def-1024-100 f-1024-l">
						<div class="display-inline-block def-300-px m-top-5 f-1024-n w-600-100">
							<figure class="def-100 t-align-c">
								<img class="display-inline-block relative" src="{{ asset('assets/landing-page/images/icons/phone.png') }}" />
							</figure>
							<div class="def-100 b-radius-5 info-contact">
								<div class="def-90 p-top-60 p-bottom-30 p-left-5 p-right-5">
									@if(isset($config->show(2)->description))
										<div class="def-100 f-w-500 color-blue f-size-18">
											Atendimento:
										</div>
										<div class="def-100 m-top-15 f-w-400 color-blue f-size-3 f-size-1024-26">
											{{ $config->show(2)->description }}
										</div>
										<div class="def-90 m-top-15 def-h-2-px m-left-5 bx-blue"></div>
									@endif
									@if(isset($config->show(3)->description))
										<div class="def-100 m-top-15 f-w-500 color-blue f-size-18">
											Comercial:
										</div>
										<div class="def-100 m-top-15 f-w-400 color-blue f-size-3 f-size-1024-26">
											{{ $config->show(3)->description }}
										</div>
									@endif
								</div>
							</div>
						</div>
						@include('landing-page.home._form', ['class' => 'def-350-px m-left-150-px def-form def-form-2 w-1024-100 m-top-1024-30'])
					</div>
				</div>
			</div>
		</div>
		<div class="def-90 p-top-15 p-bottom-15 p-left-5 p-right-5 bx-blue-2 t-align-c color-white f-size-14">
			Desenvolvido por <a class="f-none f-w-400 color-white t-decoration" href="http://www.agencias3.com.br" target="_blank" title="AGÊNCIA S3">Agência S3</a>
		</div>
	</footer>

<!-- JS -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/landing-page/js/plugins/masked.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/landing-page/js/main.js?'.date('Ymds')) }}"></script>
<script type="text/javascript" src="{{ asset('assets/landing-page/js/map.js') }}"></script>
</body>
</html>