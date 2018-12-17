<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img class="navbar-brand-full" src="{{ url(config('app.logo', 'imgs/your_logo_here.png')) }}" width="48" height="48" alt="{{ config('app.name', 'Laravel') }} Logo">
        <img class="navbar-brand-minimized" src="{{ url(config('app.logo', 'imgs/your_logo_here.png')) }}" width="30" height="30" alt="{{ config('app.name', 'Laravel') }} Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav ml-auto mr-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar mx-1" src="{{ url(Auth::user()->present()->avatar) }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow mt-2">
                <a class="dropdown-item">
                    {{ Auth::user()->name }}<br>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </a>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user"></i> @lang('accounts.profile')
                </a>
                <div class="divider"></div>
                <a class="dropdown-item" href="/password">
                    <i class="fas fa-key"></i> @lang('accounts.password')
                </a>
                <div class="divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> @lang('auth.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>