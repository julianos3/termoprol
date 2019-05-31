@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        @include('admin.layouts._page_header')
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $config['title'] }}</h2>
            </header>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12 text-right">
                        @if(isPost($_GET['all']))
                            <a href="{{ route('admin.landing-page.contact.all') }}" class="mb-xs mt-xs mr-xs btn btn-default"><i class="fa fa-undo"></i> Voltar</a>
                        @else
                        <a href="{{ route('admin.landing-page.contact.index', $landing_page_id) }}" class="mb-xs mt-xs mr-xs btn btn-default"><i class="fa fa-undo"></i> Voltar</a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label text-bold">Landing Page: </label>
                            <span class="help-block">{{ $dados->landingPage->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label text-bold">Nome: </label>
                            <span class="help-block">{{ $dados->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label text-bold">E-mail: </label>
                            <span class="help-block">{{ $dados->email }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label text-bold">Telefone: </label>
                            <span class="help-block">{{ $dados->phone }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label text-bold">Data : </label>
                            <span class="help-block">{{ date('d/m/Y h:i', strtotime($dados->created_at)) }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label text-bold">Mensagem: </label>
                            <span class="help-block">{{ $dados->message }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
