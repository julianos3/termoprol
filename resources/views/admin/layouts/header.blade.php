<header class="header">
    <div class="logo-container">
        <a href="{{ config('app.url') }}" target="_blank" class="logo" style="height: 40px!important;overflow: hidden!important;">
            {{ config('app.name') }}
        </a>
		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
    </div>
    <div class="header-right">
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="javascript:void(0);" data-toggle="dropdown">
                <figure class="profile-picture">
                    @if(Auth::user()->image)
                    <img src="{{ asset('uploads/users/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="img-circle img-responsive" data-lock-picture="{{ asset('uploads/users/'.Auth::user()->image) }}" />
                    @endif
                </figure>
                <div class="profile-info" data-lock-name="{{ Auth::user()->name }}" data-lock-email="{{ Auth::user()->email }}">
                    <span class="name">{{ Auth::user()->name }}</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>
            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('admin.configuration.user.edit', ['id'=> Auth::user()->id]) }}">
                            <i class="fa fa-user"></i> Meu Perfil
                        </a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ url('/admin/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off"></i> Sair
                            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>