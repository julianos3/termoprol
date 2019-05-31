@extends('admin.layouts.app')
@section('content')
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>{{ $config['title'] }}</h2>
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{ route('admin.home.index') }}">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li><span>Home</span></li>
                    <li><span>{{ $config['title'] }}</span></li>
                </ol>
                <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
        </header>
        <section class="panel media-gallery">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $config['title'] }}</h2>
            </header>
            <div class="panel-body">

                @include('admin.layouts._msg')
                @include('admin.modals._delete')
                @include('admin.modals._gallery')

                <?php
                $idRoute = $id;
                $routeBack = route('admin.page.edit', ['id' => $id]);
                ?>

                @include('admin.page.inc.menu')

                <div class="row cadImage" style="margin: 20px 0;">
                    <div class="col-sm-12 center">
                        <form>
                            <input id="file_upload" name="file_upload" class="mb-xs mt-xs mr-xs btn btn-primary btn-lg btn-block" type="file" multiple="true">
                            <div id="queue"></div>
                            <a class="mb-xs mt-xs mr-xs btn btn-danger" href="javascript:$('#file_upload').uploadifive('upload')"><i class="fa fa-image"></i> Upload Imagem</a>
                        </form>
                    </div>
                </div>

                <hr>

                @if(!$dados->isEmpty())
                <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                    <ul class="sortable col-sm-12" data-route="{{ route('admin.page.gallery.order', ['id' => $id]) }}">
                        @foreach($dados as $row)
                        <li class="lisort col-sm-3 div_{{ $row->id }}" id="item_{{ $row->id }}">
                            <div class="isotope-item document">
                                <div class="thumbnail">
                                    <div class="thumb-preview">
                                        <a class="thumb-image" href="{{ asset('uploads/page/'.$row->image) }}" style="height: 221px; background: url('{{ asset('uploads/page/'.$row->image) }}'); -webkit-background-size: cover;background-size: cover;"></a>
                                        <div class="mg-thumb-options">
                                            <div class="mg-zoom">
                                                <i class="fa fa-search"></i>
                                            </div>
                                            <div class="mg-toolbar">
                                                <div class="mg-group pull-right">
                                                    <a href="#modalForm" data-id="{{ $row->id }}" data-route="{{ route('admin.page.gallery.updateLabel', ['id' => $row->id]) }}" class="modal-form btnEditLabel">EDITAR</a>
                                                    <a href="#modalDestroy" data-id="{{ $row->id }}" data-route="{{ route('admin.page.gallery.destroy', ['id' => $row->id]) }}" class="modal-form excluir" data-id="<?php echo $id; ?>"><i class="fa fa-trash-o"></i> EXCLUIR</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mg-title text-semibold text-right col-md-12">
                                        CAPA
                                        <input type="checkbox" data-route="{{ route('admin.page.gallery.cover', ['id' => $row->id]) }}" <?php if($row->cover == 'y'){echo 'checked="checked"';} ?> class="cover" data-id="{{ $row->id }}" data-id-album="{{ $id }}" name="capa" />
                                    </h5>
                                    <div class="mg-description">
                                        <small class="pull-left text-muted legenda" data-id="{{ $row->id }}">{{ $row->label }}</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </section>
    </section>
@endsection
