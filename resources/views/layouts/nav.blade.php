<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <x-application-logo class="d-inline-block align-text-top" style="height: 36px;" />
        </a>

        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('doctor') ? 'active' : '' }}" href="{{ route('doctor') }}">
                        {{ __('Doctor') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nutritionist') ? 'active' : '' }}" href="{{ route('nutritionist.index') }}">
                        {{ __('Nutritionist') }}
                    </a>
                </li>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'nutritionist')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('nutritionist-visit') ? 'active' : '' }}" href="{{ route('nutritionist-visit.index') }}">
                        {{ __('Nutritionist-visit') }}
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('patient') ? 'active' : '' }}" href="{{ route('patient') }}">
                        {{ __('Patient') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('medical-report.index') ? 'active' : '' }}" href="{{ route('medical-report.index') }}">
                        {{ __('Patient Visit') }}
                    </a>
                </li>
                @if(Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}" href="{{ route('role.index') }}">
                        {{ __('Role') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.register') ? 'active' : '' }}" href="{{ route('user.register') }}">
                        {{ __('Register') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('problem.wise.patient') ? 'active' : '' }}" href="{{ route('problem.wise.patient') }}">
                        {{ __('Problem wise Patient') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('comment.wise.patient') ? 'active' : '' }}" href="{{ route('comment.wise.patient') }}">
                        {{ __('Comment wise Patient') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('references.index') ? 'active' : '' }}" href="{{ route('references.index') }}">
                        {{ __('Reference wise Patient') }}
                    </a>
                </li>

                @endif
            </ul>

            <!-- Settings Dropdown -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.useredit') }}">{{ __('Profile') }}</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
