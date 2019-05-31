<?php if(isset($routeContact)){ ?>
{!! Form::open(['route' => 'admin.landing-page.contact.all', 'method' => 'get']) !!}
<?php }else{ ?>
{!! Form::open(['route' => ['admin.landing-page.contact.index', $landing_page_id], 'method' => 'get']) !!}
<?php }  ?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::text('from', null, ['class'=>'form-control mb-md', 'placeholder' => 'De', 'data-plugin-datepicker data-plugin-masked-input', 'data-input-mask' => '99/99/9999']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::text('to', null, ['class'=>'form-control mb-md', 'placeholder' => 'Até', 'data-plugin-datepicker data-plugin-masked-input', 'data-input-mask' => '99/99/9999']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <?php if(isset($routeContact)){ ?>
        <a href="{{ route('admin.landing-page.contact.all') }}" title="Limpar" class="btn btn-danger mb-md"><i class="fa fa-trash"></i> Limpar</a>
        <?php }else{ ?>
        <a href="{{ route('admin.landing-page.contact.index', $landing_page_id) }}" title="Limpar" class="btn btn-danger mb-md"><i class="fa fa-trash"></i> Limpar</a>
        <?php }  ?>
        <button type="submit" class="btn btn-warning mb-md" value="Filtrar Dados"><i class="fa fa-search-plus"></i> Filtrar Dados</button>
    </div>
</div>
{!! Form::close() !!}