@extends('landing-page.layouts.app')
@section('content')
    @inject("config", "\AgenciaS3\Http\Controllers\Site\ConfigurationController")
    @if(isset($landingPage->banner))
    <figure class="def-100 relative z-index-1 banner -main-banner -main-height h-1024-auto m-top-1024-90" id="home">
        <img class="def-100 -none display-1024-block" src="{{ asset('uploads/landing-page/'.$landingPage->banner) }}" title="{{ $landingPage->name }}" alt="{{ $landingPage->name }}"/>
        <div class="def-100 def-h-100 absolute top-0 left-0 relative-1024">
            <div class="def-100 def-h-100 table">
                <div class="inline">
                    <div class="def-100">
                        <div class="def-center">
                            @include('landing-page.home._form', ['class' => 'def-350-px f-right def-form w-1024-100 p-top-1024-30 p-bottom-1024-30 t-align-1024-c'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </figure>
    @endif
<div class="def-100 p-top-100 p-bottom-100 background-1 p-top-1024-30 p-bottom-1024-30" id="service">
    <div class="def-center">
        <div class="def-48 p-top-35 p-bottom-35 w-800-100 p-top-800-0 p-bottom-800-10">
            <h1 class="def-100 t-align-r def-title t-align-800-c">
                <?php
                $title = explode(" ", $landingPage->name);
                $totalT = count($title);
                $contT = 0;
                foreach ($title as $t) {
                    $contT++;
                    if ($contT < $totalT) {
                        echo $t . ' ';
                    }
                }
                ?>
                <strong>{{ end($title) }}</strong>
            </h1>
        </div>
        <div class="def-48 f-right w-800-100">
            <div class="def-80 def-text m-bottom-20 w-800-100 t-align-800-c">
                {!! $landingPage->description !!}
            </div>
        </div>
    </div>
</div>
    @if(!$products->isEmpty())
        <?php $cont = 0; ?>
        @foreach($products as $row)
            <?php
            $cont++;
            switch ($cont) {
                case 1:
                    $background = 'background-2';
                    $classImg = 'def-60 w-800-100';
                    $classFigure = 'def-120 f-right w-800-100 t-align-800-c';
                    break;
                case 2:
                    $background = 'background-3';
                    $classImg = 'def-60 f-right w-800-100 f-800-l';
                    $classFigure = 'def-110 f-left w-800-100 t-align-800-c';
                    break;
                case 3:
                    $background = 'background-4';
                    $classImg = 'def-60 w-800-100';
                    $classFigure = 'def-100 f-right t-align-800-c';
                    break;
            }            if ($cont == 3) {
                $cont = 0;
            }
            ?>
            <div class="def-100 p-top-100 p-bottom-50 {{ $background }} p-top-1024-30 p-bottom-1024-30">
                <div class="def-center">
                    @if(isset($row->image))
                        <div class="{{ $classImg }}">
                            <figure class="{{ $classFigure }}"><img class="display-inline-block f-right f-800-n w-800-auto max-w-100" src="{{ asset('uploads/landing-page/'.$row->image) }}" title="{{ $row->name }}" alt="{{ $row->name }}"/></figure>
                        </div>
                    @endif
                    <div class="@if(isset($row->image)) def-37 f-right @else def-100 @endif w-800-100 m-top-800-20 t-align-800-c">
                        <h2 class="def-100 def-title">
                            <?php
                            $title = explode(" ", $row->name);
                            $totalT = count($title);
                            $contT = 0;
                            foreach ($title as $t) {
                                $contT++;
                                if ($contT < $totalT) {
                                    echo $t . ' ';
                                }
                            }
                            ?>
                                <strong>{{ end($title) }}</strong>
                        </h2>
                        <div class="def-100 m-top-20 def-text def-text-2 w-800-100">
                            {!! $row->description !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @if(isset($landingPage->video))
    <div class="def-100 p-top-60 p-bottom-60 background-5 p-bottom-50 p-top-1024-30 p-bottom-1024-30">
        <div class="def-center">
            <iframe class="def-100 def-h-500-px h-1024-300-px h-600-250-px" width="100%" height="500px" src="{{ $landingPage->video }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
    @endif
    @if(isset($config->show(1)->description))
    <iframe class="def-100" src="{{ $config->show(1)->description }}" width="100%" height="280px" frameborder="0" style="border:0" allowfullscreen></iframe>
    @endif
@endsection