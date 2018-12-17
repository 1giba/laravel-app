<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard">
                    <i class="nav-icon icon-speedometer"></i> @lang('app.dashboard')
                </a>
            </li>
            <li class="nav-title">@lang('app.settings')</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="nav-icon icon-user"></i> @lang('users.index')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('roles') }}">
                    <i class="nav-icon icon-lock"></i> @lang('roles.index')
                </a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
