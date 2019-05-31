@extends('admin.layouts.login')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Recuperar Senha</h2>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="alert alert-info">
                        <p class="m-none text-semibold h6">Digite o seu e-mail abaixo e uma nova senha será enviada!</p>
                    </div>
                    <form role="form" method="POST" action="{{ url('/admin/password/email') }}">
                        {{ csrf_field() }}
                        <div class="form-group mb-none{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <input name="email" type="email" placeholder="E-mail" class="form-control input-lg" value="{{ old('email') }}" required/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-lg" type="submit">Recuperar!</button>
                                </span>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <p class="text-center mt-lg">Lembrou? <a href="{{ url('/admin/login') }}">Login!</a>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright {{ date('Y') }}. Todos os direitos reservados.</p>
        </div>
    </section>
@endsection
