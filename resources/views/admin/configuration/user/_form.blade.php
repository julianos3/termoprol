<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('name', 'Nome *') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('role', 'Nível *') !!}
            {!! Form::select('role', ['admin' => 'Administrador', 'user' => 'Usuário'], null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>

@if(!isset($dados->id))
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password', 'Senha') !!}
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Confirmar Senha *') !!}
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required />
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Imagem</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input">
                        <i class="fa fa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Trocar</span>
                        <span class="fileupload-new">Selecionar Imagem</span>
                        <input type="file" name="image" />
                    </span>
                    <a href="#" class="btn btn-default   fileupload-exists" data-dismiss="fileupload">Remover</a>
                    <?php if(isset($dados->image) && $dados->image != ''){ ?>
                    <a href="{{ asset('uploads/users/'.$dados->image) }}" class="lightBox btn btn-default active">Visualizar Imagem</a>
                    <a href="{{ route('admin.configuration.user.destroyImage', ['id' => $dados->id]) }}" class="btn btn-default">Deletar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>