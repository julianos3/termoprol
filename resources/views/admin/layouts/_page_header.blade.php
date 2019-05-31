<header class="page-header">
    <h2>@if(isset($config['preTitle'])) {{ $config['preTitle'].' > '}} @endif {{ $config['title'] }}</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{ route('admin.home.index') }}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Home</span></li>
            @if(isset($config['preTitle']))
                <li><span>{{ $config['preTitle'] }}</span></li>
            @endif
            <li><span>{{ $config['title'] }}</span></li>
            @if(isset($config['action']))
            <li><span>{{ $config['action'] }}</span></li>
            @endif
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>

    </div>
</header>