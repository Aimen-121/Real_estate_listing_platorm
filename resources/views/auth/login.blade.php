<x-guest-layout>
    <h3 class="fw-bold mb-3 text-center">Welcome Back</h3>
    <p class="text-muted text-center mb-4">Please log in to your account.</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4 rounded-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="Email" class="form-label fw-semibold">Email Address</label>
            <input id="Email" type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" value="{{ old('Email') }}" required autofocus autocomplete="username">
            @error('Email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="Password" class="form-label fw-semibold mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none text-primary-custom small" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="Password" type="password" name="Password" class="form-control @error('Password') is-invalid @enderror" required autocomplete="current-password">
            @error('Password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label text-muted small" for="remember_me">Remember me on this device</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary-custom py-2 fw-bold text-uppercase">Log In</button>
        </div>

        <div class="text-center">
            <a class="text-decoration-none text-muted small" href="{{ route('register') }}">
                Don't have an account? <span class="text-primary-custom fw-semibold">Register</span>
            </a>
        </div>
    </form>
</x-guest-layout>
