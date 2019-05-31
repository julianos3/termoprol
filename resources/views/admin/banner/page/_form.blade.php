@include('admin.layouts.forms._name')
@include('admin.layouts.forms._target_link_url')
@include('admin.layouts.forms._active_order')
@include('admin.layouts.forms._image', [
    'dados' => isset($dados) ? $dados : null,
    'size' => '1920px de largura, conteúdo principal centralizado',
    'route_destroy' => isset($dados) ? route('admin.banner.page.destroyImage', ['id' => $dados->id]) : null,
    'path' => 'banner-page'
])