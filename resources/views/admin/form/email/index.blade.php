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
                <h2 class="panel-title">{{ $config['title'].' > '.$config['action'] }}</h2>
            </header>

            {!! Form::open(['route'=>'admin.form.email.store', 'files'=> true]) !!}
            <div class="panel-body">

                @include('admin.layouts._msg')
                @include('admin.modals._delete')

                <?php
                $idRoute = $id;
                $routeBack = route('admin.form.edit', ['id' => $id]);
                ?>

                @include('admin.form.inc.menu')

                @include('admin.form.email._form')

            </div>
            <footer class="panel-footer text-right">
                <button type="submit"
                        class="btn btn-raised btn-success waves-effect waves-light">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Adicionar
                </button>
            </footer>
            {!! Form::close() !!}
        </section>

        @if(!$dados->isEmpty())
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">E-mails</h2>
                </header>
                <div class="panel-body">
                    <table class="table table-no-more table-bordered table-striped mb-0">
                        <thead>
                        <tr>
                            <th>E-mail</th>
                            <th class="col-md-2 text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $row)
                            <tr>
                                <td data-title="E-mail">{{ $row->email }}</td>
                                <td data-title="Ação" class="actions text-center">
                                    <a href="#modalDestroy" data-route="{{ route('admin.form.email.destroy', ['id' => $row->id]) }}" class="excluir remove-row btn btn-danger white" title="Excluir">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </section>
@endsection
