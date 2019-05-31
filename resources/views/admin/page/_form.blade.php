<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('name', 'Titulo *') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>

@if(isset($dados))
    @if($dados->id == 14 || $dados->id == 2 || $dados->id == 3  || $dados->id == 11 || $dados->id == 23)
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('sub_name', 'Sub Título *') !!}
                {!! Form::text('sub_name', null, ['class'=>'form-control', 'required' => 'required']) !!}
            </div>
        </div>
    </div>
    @endif
@endif

@if(isset($dados))
    @if($dados->id == 9 || $dados->id == 12 || $dados->id == 17 || $dados->id == 23)
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('video', 'Vídeo *') !!}
                {!! Form::text('video', null, ['class'=>'form-control', 'required' => 'required']) !!}
            </div>
        </div>
    </div>
    @endif
@endif

@if(isset($dados))
    @if($dados->id == 1 || $dados->id == 2 || $dados->id == 3 || $dados->id == 7 || $dados->id == 10 || $dados->id == 15 || $dados->id == 19 || $dados->id == 23)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Imagem @if(isset($imageSize)) <strong>({{ $imageSize }})</strong> @endif</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input">
                        <i class="fa fa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Trocar</span>
                        <span class="fileupload-new">Selecionar</span>
                        <input type="file" name="image" />
                    </span>
                    <a href="#" class="btn btn-default   fileupload-exists" data-dismiss="fileupload">Remover</a>
                    <?php if(isset($dados->image) && $dados->image != ''){ ?>
                    <a href="{{ asset('uploads/page/'.$dados->image) }}" class="lightBox btn btn-default active">Visualizar</a>
                    <a href="{{ route('admin.page.destroyImage', ['id' => $dados->id]) }}" class="btn btn-default">Deletar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
    @endif
@endif

@if(isset($dados))
    @if($dados->id != 9 && $dados->id != 17 && $dados->id != 19)
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('description', 'Descrição') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control ckeditor']) !!}
        </div>
    </div>
</div>
    @endif
@endif