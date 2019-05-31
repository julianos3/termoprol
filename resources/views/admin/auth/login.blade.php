@extends('admin.layouts.login')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Login</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ url('/admin/login') }}" role="form" method="post">
                        {{ csrf_field() }}
                        <div class="form-group mb-lg {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-mail</label>
                            <div class="input-group input-group-icon">
                                <input name="email" type="email" id="email" value="{{ old('email') }}" class="form-control input-lg" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
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
                                <a href="{{ url('/admin/password/reset') }}" class="pull-right">Esqueceu a senha?</a>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" type="password" id="password" class="form-control input-lg" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="remember" name="remember" {{ old('remember') ? 'checked' : ''}} type="checkbox" />
                                    <label for="remember">Lembre-me</label>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-default hidden-xs">Entrar</button>
                                <button type="submit" class="btn btn-default btn-block btn-lg visible-xs mt-lg">Entrar</button>
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
