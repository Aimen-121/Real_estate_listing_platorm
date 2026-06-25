<x-guest-layout>
    <h3 class="fw-bold mb-3 text-center">Create Account</h3>
    <p class="text-muted text-center mb-4">Join our Real Estate Platform today.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div class="mb-3">
            <label for="Full_Name" class="form-label fw-semibold">Full Name</label>
            <input id="Full_Name" type="text" name="Full_Name" class="form-control @error('Full_Name') is-invalid @enderror" value="{{ old('Full_Name') }}" required autofocus autocomplete="name">
            @error('Full_Name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="Email" class="form-label fw-semibold">Email Address</label>
            <input id="Email" type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" value="{{ old('Email') }}" required autocomplete="email">
            @error('Email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
            <label for="Phone_Number" class="form-label fw-semibold">Phone Number</label>
            <input id="Phone_Number" type="text" name="Phone_Number" class="form-control @error('Phone_Number') is-invalid @enderror" value="{{ old('Phone_Number') }}" autocomplete="tel">
            @error('Phone_Number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Identity Details -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="Identity_Type" class="form-label fw-semibold">Identity Type</label>
                <select id="Identity_Type" name="Identity_Type" class="form-select @error('Identity_Type') is-invalid @enderror">
                    <option value="" selected>Select Type</option>
                    <option value="CNIC" {{ old('Identity_Type') == 'CNIC' ? 'selected' : '' }}>CNIC</option>
                    <option value="Passport" {{ old('Identity_Type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                    <option value="Driving License" {{ old('Identity_Type') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                </select>
                @error('Identity_Type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="Identity_Number" class="form-label fw-semibold">Identity Number</label>
                <input id="Identity_Number" type="text" name="Identity_Number" class="form-control @error('Identity_Number') is-invalid @enderror" value="{{ old('Identity_Number') }}">
                @error('Identity_Number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Role Selection -->
        <div class="mb-4 p-3 bg-light rounded-3">
            <label class="form-label d-block fw-bold mb-2 text-primary-custom"><i class="bi bi-person-badge me-1"></i> Register As (Select all that apply)</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="buyer" id="role_buyer" {{ is_array(old('roles')) && in_array('buyer', old('roles')) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="role_buyer">Buyer</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="renter" id="role_renter" {{ is_array(old('roles')) && in_array('renter', old('roles')) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="role_renter">Renter</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="owner" id="role_owner" {{ is_array(old('roles')) && in_array('owner', old('roles')) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="role_owner">Owner</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="agent" id="role_agent" {{ is_array(old('roles')) && in_array('agent', old('roles')) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="role_agent">Agent</label>
                </div>
            </div>
            @error('roles')
                <div class="text-danger mt-1 small d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="Password" class="form-label fw-semibold">Password</label>
            <input id="Password" type="password" name="Password" class="form-control @error('Password') is-invalid @enderror" required autocomplete="new-password">
            @error('Password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="Password_confirmation" class="form-label fw-semibold">Confirm Password</label>
            <input id="Password_confirmation" type="password" name="Password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary-custom py-2 fw-bold text-uppercase">Register</button>
        </div>

        <div class="text-center">
            <a class="text-decoration-none text-muted small" href="{{ route('login') }}">
                Already registered? <span class="text-primary-custom fw-semibold">Log in</span>
            </a>
        </div>
    </form>
</x-guest-layout>
