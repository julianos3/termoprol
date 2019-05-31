{!! Form::hidden('landing_page_id', $landing_page_id, ['class'=>'form-control']) !!}
@include('admin.layouts.forms._name')
@include('admin.layouts.forms._active_order')
@include('admin.layouts.forms._file', [
    'label' => 'Imagem',
    'dados' => isset($dados) ? $dados : null,
    'size' => '600px de largura',
    'route_destroy' => isset($dados) ? route('admin.landing-page.product.destroyFile', ['id' => $dados->id, 'name' => 'image']) : null,
    'attribute' => 'image',
    'path' => 'landing-page'
])
@include('admin.layouts.forms._description')