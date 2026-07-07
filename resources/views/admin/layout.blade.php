<x-app-layout>
    <div class="container py-5">
        <!-- Admin Title Banner -->
        <div class="page-header-banner shadow-sm mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1 text-primary-custom">
                        <i class="bi bi-shield-lock-fill me-2"></i>Administration Console
                    </h2>
                    <p class="text-muted mb-0">
                        Logged in as: <strong>{{ auth()->user()->Full_Name }}</strong> ({{ auth()->user()->admin->Admin_Role ?? 'Administrator' }})
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary-custom btn-sm fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Back to User Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Sidebar & Content Grid -->
        <div class="row g-4">
            <!-- Left Navigation Sidebar -->
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>

            <!-- Right Content Area -->
            <div class="col-lg-9">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
