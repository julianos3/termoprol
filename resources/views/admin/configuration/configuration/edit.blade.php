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
            {!! Form::model($dados, ['route'=>['admin.configuration.configuration.update', $dados->id]]) !!}
            <div class="panel-body">

                @include('admin.layouts._msg')

                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="{{ route('admin.configuration.configuration.index') }}" class="mb-xs mt-xs mr-xs btn btn-default"><i class="fa fa-undo"></i> Voltar</a>
                    </div>
                </div>

                @include('admin.configuration.configuration._form')

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
