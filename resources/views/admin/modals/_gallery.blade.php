<div id="modalForm" class="zoom-anim-dialog modal-block modal-block-black mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Editar Legenda</h2>
        </header>
        <div class="panel-body">
            <div class="form-group mt-lg">
                <label class="col-sm-3 control-label">Legenda:</label>
                <div class="col-sm-9">
                    <input type="text" name="legenda" id="legenda-input" class="form-control" placeholder="Informe a legenda..." required/>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="javascript:void(0);" class="btn btnSalvarLegenda btn-default modal-confirm" data-route="" data-id="{{ $id }}">Salvar</a>
                    <button class="btn btn-default modal-dismiss">Cancelar</button>
                </div>
            </div>
        </footer>
    </section>
</div>
