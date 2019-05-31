@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Home</h2>

            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{ route('admin.home.index') }}">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li><span>Home</span></li>
                </ol>

                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
        </header>


        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Conteúdo do Gerenciador</h2>
            </header>
            <div class="panel-body">
                <p class="lead">Olá {{ Auth::user()->name }},<br><br>
                    Seja bem vindo ao seu gerenciador de conteúdo do site Agência S3 onde você poderá deixar sempre o seu site atualizado de forma simples e eficaz.<br>
                    Qualquer dúvida você pode entrar em contato pelo email <a href="mailto:contato@agencias3.com.br" title="contato@agencias3.com.br">contato@agencias3.com.br</a>
                </p>
            </div>
        </section>

        <!-- start: page -->
        <!-- end: page -->
    </section>
@endsection
