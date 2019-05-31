<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Menu
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Menu"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li @if(isset($config['activeMenu']) && $config['activeMenu'] == 'home')class="nav-expanded nav-active"@endif>
                        <a href="{{ route('admin.home.index') }}">
                            <i class="glyphicon glyphicon-th" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'landing-page') nav-expanded nav-active @endif">
                        <a>
                            <i class="fa fa-file-text" aria-hidden="true"></i>
                            <span>Landing Page</span>
                        </a>
                        <ul class="nav nav-children">
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'landing-page')class="active"@endif>
                                <a href="{{ route('admin.landing-page.index') }}">
                                    Landing Page
                                </a>
                            </li>
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'contact')class="active"@endif>
                                <a href="{{ route('admin.landing-page.contact.all') }}">
                                    Contatos
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li @if(isset($config['activeMenu']) && $config['activeMenu'] == 'page')class="nav-expanded nav-active"@endif>
                        <a href="{{ route('admin.page.index') }}">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <span>Páginas e Textos</span>
                        </a>
                    </li>
                    <li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'form') nav-expanded nav-active @endif">
                        <a>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <span>Formulários</span>
                        </a>
                        <ul class="nav nav-children">
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'newsletter')class="active"@endif>
                                <a href="{{ route('admin.newsletter.index') }}">
                                    Newsletter
                                </a>
                            </li>
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'form')class="active"@endif>
                                <a href="{{ route('admin.form.index') }}">
                                    Formulários
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent @if(isset($config['activeMenu']) && $config['activeMenu'] == 'configuration') nav-expanded nav-active @endif">
                        <a>
                            <i class="fa fa-gears" aria-hidden="true"></i>
                            <span>Configurações</span>
                        </a>
                        <ul class="nav nav-children">
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'configuration')class="active"@endif>
                                <a href="{{ route('admin.configuration.configuration.index') }}">
                                    Configurações
                                </a>
                            </li>
                            <li @if(isset($config['activeMenuN2']) && $config['activeMenuN2'] == 'newsletter')class="active"@endif>
                                <a href="{{ route('admin.configuration.user.index') }}">
                                    Usuários
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>


