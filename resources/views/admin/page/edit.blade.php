@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>{{ $config['title'] }}</h2>

            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{ route('admin.home.index') }}">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li><span>Home</span></li>
                    <li><span>{{ $config['title'] }}</span></li>
                    <li><span>{{ $config['action'] }}</span></li>
                </ol>

                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
        </header>
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $config['title'] }}</h2>
            </header>
            {!! Form::model($dados, ['route'=>['admin.page.update', $dados->id], 'files'=> true]) !!}
            <div class="panel-body">

                @include('admin.layouts._msg')

                <?php
                $idRoute = $dados->id;
                $routeBack = route('admin.page.index');
                ?>

                @include('admin.page.inc.menu')
                @include('admin.page._form')

            </div>
            <footer class="panel-footer text-right">
                <button type="submit"
                        class="btn btn-raised btn-success waves-effect waves-light">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Salvar Alteração
                </button>
            </footer>
            {!! Form::close() !!}
        </section>
    </section>
@endsection
