<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">{{ $label }} @if(isset($size))<strong>( {{ $size }} )</strong>@endif</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input">
                        <i class="fa fa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Trocar</span>
                        <span class="fileupload-new">Selecionar</span>
                        <input type="file" name="{{ $attribute }}" />
                    </span>
                    <a href="#" class="btn btn-default   fileupload-exists" data-dismiss="fileupload">Remover</a>
                    <?php if(isset($dados->$attribute) && $dados->$attribute != ''){ ?>
                    <a href="{{ asset('uploads/'.$path.'/'.$dados->$attribute) }}" class="lightBox btn btn-default active">Visualizar</a>
                    <a href="{{ $route_destroy }}" class="btn btn-default">Deletar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>