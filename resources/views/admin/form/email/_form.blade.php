<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('email', 'E-mail *') !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    {!! Form::hidden('form_id', $id, ['required' => 'required']) !!}
</div>
<br />