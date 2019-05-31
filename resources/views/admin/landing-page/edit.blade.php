@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        @include('admin.layouts._page_header')
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $config['title'].' > '.$config['action'] }}</h2>
            </header>

            {!! Form::model($dados, ['route'=>['admin.landing-page.update', $dados->id], 'files' => true]) !!}
                <div class="panel-body">

                    @include('admin.layouts._msg')

                    <?php
                    $idRoute = $dados->id;
                    $routeBack = route('admin.landing-page.index');
                    ?>

                    @include('admin.landing-page.inc.menu')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Página: <a href="{{ route('show', $dados->seo_link) }}" target="_blank">{{ route('show', $dados->seo_link) }}</a>
                            </div>
                        </div>
                    </div>

                    @include('admin.landing-page._form')

                </div>
                <footer class="panel-footer text-right">
                    <button type="submit" class="btn btn-raised btn-success waves-effect waves-light">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Salvar Alteração
                    </button>
                </footer>
            {!! Form::close() !!}
        </section>
    </section>
@endsection
