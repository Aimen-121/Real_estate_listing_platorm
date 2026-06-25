<nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary-custom fs-4" href="/">
            <i class="bi bi-houses-fill me-1"></i> RealEstate
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold {{ request()->is('/') ? 'active text-primary-custom' : '' }}" href="/">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('dashboard') ? 'active text-primary-custom' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item me-3 d-none d-lg-block">
                        <div class="d-flex flex-wrap gap-1 align-items-center">
                            @foreach(auth()->user()->getRoles() as $role)
                                <span class="badge bg-secondary-custom rounded-pill py-1 px-2 fw-semibold text-primary-custom" style="font-size: 0.75rem;">
                                    {{ $role }}
                                </span>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2 fs-5 text-primary-custom"></i>
                            {{ auth()->user()->Full_Name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 mt-2">
                            <li>
                                <a class="dropdown-item fw-medium py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-gear me-2 text-muted"></i>Profile Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger fw-medium py-2" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-link text-decoration-none fw-medium text-dark" href="{{ route('login') }}">Log in</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary-custom px-4" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
