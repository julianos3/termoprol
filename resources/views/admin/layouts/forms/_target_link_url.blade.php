<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('target_blank', 'Abrir em nova aba? *') !!}
            {!! Form::select('target_blank', ['y' => 'Sim', 'n' => 'Não'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('link_url', 'Link') !!}
            {!! Form::url('link_url', null, ['class'=>'form-control', 'maxlength' => 450]) !!}
        </div>
    </div>
</div>