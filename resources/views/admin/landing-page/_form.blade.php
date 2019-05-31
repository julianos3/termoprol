@include('admin.layouts.forms._name')

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('video', 'Vídeo') !!}
            {!! Form::text('video', null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('active', 'Ativo? *') !!}
            {!! Form::select('active', ['y' => 'Sim', 'n' => 'Não'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>

@include('admin.layouts.forms._file', [
    'label' => 'Banner',
    'dados' => isset($dados) ? $dados : null,
    'size' => '1920px X 1080px, conteúdo principal centralizado',
    'route_destroy' => isset($dados) ? route('admin.landing-page.destroyFile', ['id' => $dados->id, 'name' => 'banner']) : null,
    'attribute' => 'banner',
    'path' => 'landing-page'
])
@include('admin.layouts.forms._file', [
    'label' => 'Avatar Facebook',
    'dados' => isset($dados) ? $dados : null,
    'size' => '1200px X 630px, conteúdo principal centralizado',
    'route_destroy' => isset($dados) ? route('admin.landing-page.destroyFile', ['id' => $dados->id, 'name' => 'avatar_1_6']) : null,
    'attribute' => 'avatar_1_6',
    'path' => 'landing-page'
])
@include('admin.layouts.forms._file', [
    'label' => 'Avatar WhatsApp',
    'dados' => isset($dados) ? $dados : null,
    'size' => '300px X 300px, conteúdo principal centralizado',
    'route_destroy' => isset($dados) ? route('admin.landing-page.destroyFile', ['id' => $dados->id, 'name' => 'avatar_1_1']) : null,
    'attribute' => 'avatar_1_1',
    'path' => 'landing-page'
])

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::text('email', null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

@include('admin.layouts.forms._seo_keywords_description')
@include('admin.layouts.forms._description')