<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Page Title -->
                <div class="page-header-banner shadow-sm mb-4">
                    <h2 class="fw-bold mb-1 text-primary-custom"><i class="bi bi-gear-wide-connected me-2"></i>Account Profile Settings</h2>
                    <p class="text-muted mb-0">Manage your contact information, credentials, and account options.</p>
                </div>

                <!-- Update Info Card -->
                <div class="card card-custom mb-4 p-4 p-md-5">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password Card -->
                <div class="card card-custom mb-4 p-4 p-md-5">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account Card -->
                <div class="card card-custom border-danger mb-4 p-4 p-md-5" style="border-left: 4px solid #dc3545 !important;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
