@extends('admin.layouts.login')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Trocar Senha</h2>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ url('/admin/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group mb-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-mail</label>
                            <div class="input-group input-group-icon">
                                <input name="email" type="email" id="email" value="{{ $email or old('email') }}" class="form-control input-lg" required autofocus/>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-lg {{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="clearfix">
                                <label class="pull-left" id="password">Senha</label>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" type="password" id="password" class="form-control input-lg" required />
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-lg{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="clearfix">
                                <label class="pull-left" id="password-confirm">Confirmar Senha</label>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password_confirmation" type="password" id="password-confirm" class="form-control input-lg" required />
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-default hidden-xs">Trocar Senha</button>
                                <button type="submit" class="btn btn-default btn-block btn-lg visible-xs mt-lg">Trocar Senha</button>
                            </div>
                            <br /><br />
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright {{ date('Y') }}. Todos os direitos reservados.</p>
        </div>
    </section>
@endsection
