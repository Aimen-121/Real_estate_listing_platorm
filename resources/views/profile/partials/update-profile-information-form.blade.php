<section>
    <header class="mb-4">
        <h4 class="fw-bold">Profile Information</h4>
        <p class="text-muted small">Update your account's profile information and email address.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Full Name -->
        <div class="mb-3">
            <label for="profile_Full_Name" class="form-label fw-semibold">Full Name</label>
            <input id="profile_Full_Name" name="Full_Name" type="text" class="form-control @error('Full_Name', 'profileUpdate') is-invalid @enderror" value="{{ old('Full_Name', $user->Full_Name) }}" required autofocus autocomplete="name">
            @error('Full_Name', 'profileUpdate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="profile_Email" class="form-label fw-semibold">Email Address</label>
            <input id="profile_Email" name="Email" type="email" class="form-control @error('Email', 'profileUpdate') is-invalid @enderror" value="{{ old('Email', $user->Email) }}" required autocomplete="username">
            @error('Email', 'profileUpdate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
            <label for="profile_Phone_Number" class="form-label fw-semibold">Phone Number</label>
            <input id="profile_Phone_Number" name="Phone_Number" type="text" class="form-control @error('Phone_Number', 'profileUpdate') is-invalid @enderror" value="{{ old('Phone_Number', $user->Phone_Number) }}" autocomplete="tel">
            @error('Phone_Number', 'profileUpdate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary-custom px-4">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small"><i class="bi bi-check-circle-fill me-1"></i>Saved successfully.</span>
            @endif
        </div>
    </form>
</section>
