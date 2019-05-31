<div class="row">
    <div class="@if(isset($class)) {{ $class }} @else col-md-6 @endif">
        <br />
        <div class="alert alert-info"><strong>SEO KEYWORDS:</strong> Máximo de 255 caracteres, palavras separadas por virgula</div>
        <div class="form-group">
            {!! Form::label('seo_keywords', 'SEO Keywords * (Máximo de 255 caracteres, palavras separadas por virgula)') !!}
            {!! Form::text('seo_keywords', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="@if(isset($class)) {{ $class }} @else col-md-6 @endif">
        <br />
        <div class="alert alert-info"><strong>SEO DESCRIÇÂO:</strong> Recomendamos não ultrapassar 160 caracteres</div>
        <div class="form-group">
            {!! Form::label('seo_description', 'SEO Descrição Página * (Recomendamos não ultrapassar 160 caracteres)') !!}
            {!! Form::text('seo_description', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>