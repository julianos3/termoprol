@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        @include('admin.layouts._page_header')
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $config['title'] }}</h2>
            </header>
            <div class="panel-body">

                @include('admin.layouts._msg')
                @include('admin.modals._delete')

                <?php
                $idRoute = $landing_page_id;
                $routeBack = route('admin.landing-page.edit', $landing_page_id);
                ?>

                @include('admin.landing-page.inc.menu')
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <div class="mb-md">
                            <a href="{{ route('admin.landing-page.contact.export', $landing_page_id) }}" title="Exportar" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> Exportar</a>
                        </div>
                    </div>
                </div>

                @include('admin.landing-page.contact._form_filter')

                @if($dados->isEmpty())
                <div class="text-center">
                    <h4>Nenhum registro encontrado ou cadastrado.</h4>
                </div>
                @else
                <table class="table table-no-more table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th class="col-md-1 text-center">Lido</th>
                            <th class="text-center">Data</th>
                            <th class="col-md-2 text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($dados as $row)
                        <tr>
                            <td data-title="Nome">{{ $row->name }}</td>
                            <td data-title="Telefone">{{ $row->phone }}</td>
                            <td data-title="E-mail">{{ $row->email }}</td>
                            <td data-title="Lido" class="text-center"><i class="fa  @if($row->view == 'y') fa-check-square alert-success @else fa-times-circle alert-danger @endif"></i></td>
                            <td data-title="Data" class="text-center">{{ date('d/m/Y h:i', strtotime($row->created_at)) }}</td>
                            <td class="actions text-center" data-title="Ação">
                                <a href="{{ route('admin.landing-page.contact.show', ['id' => $row->id]) }}" class="btn btn-default white-hover" title="Visualizar"><i class="fa el-icon-search"></i></a>
                                <a href="#modalDestroy" data-route="{{ route('admin.landing-page.contact.destroy', ['id' => $row->id]) }}" class="excluir remove-row btn btn-danger white" title="Excluir">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $dados->links() }}
                @endif
            </div>
        </section>
    </section>
@endsection
