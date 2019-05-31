@if(isset($dados->id))
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('seo_link', 'URL da Página * (Não utilizar espaços)') !!}
            {!! Form::text('seo_link', null, ['class'=>'form-control', 'required' => 'required', 'maxlength' => 255]) !!}
        </div>
    </div>
</div>
@endif
