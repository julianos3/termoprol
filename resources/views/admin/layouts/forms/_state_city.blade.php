<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('state_id', 'Estado *') !!}
            {!! Form::select('state_id', $states, null, ['data-classe' => 'city_id', 'class'=>'form-control mb-md uf']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('city_id', 'Cidade *') !!}
            {!! Form::select('city_id', isset($cities) ? $cities : ['' => 'Selecione'], null, ['class'=>'form-control mb-md city_id']) !!}
        </div>
    </div>
</div>