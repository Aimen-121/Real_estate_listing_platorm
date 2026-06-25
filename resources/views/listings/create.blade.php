<x-app-layout>
    <div class="container py-5" style="max-width:680px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
            <h3 class="fw-bold mb-0">Create New Listing</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card card-custom p-4">
            <form action="{{ route('listings.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Property <span class="text-danger">*</span></label>
                    <select name="Property_ID" class="form-select" required>
                        <option value="">Select a property…</option>
                        @foreach($properties as $prop)
                            <option value="{{ $prop->Property_ID }}" {{ old('Property_ID') == $prop->Property_ID ? 'selected' : '' }}>
                                {{ $prop->Title }} – {{ $prop->City }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Listing Type <span class="text-danger">*</span></label>
                        <select name="Listing_Type" class="form-select" required>
                            <option value="Sale" {{ old('Listing_Type') == 'Sale' ? 'selected' : '' }}>For Sale</option>
                            <option value="Rent" {{ old('Listing_Type') == 'Rent' ? 'selected' : '' }}>For Rent</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Listing Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="Price" class="form-control" value="{{ old('Price') }}" min="0" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Listing Date <span class="text-danger">*</span></label>
                        <input type="date" name="Listing_Date" class="form-control" value="{{ old('Listing_Date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                        <input type="date" name="Expire_Date" class="form-control" value="{{ old('Expire_Date') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Listing Description <span class="text-danger">*</span></label>
                    <textarea name="Description" class="form-control" rows="4" required>{{ old('Description') }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="Featured_Flag" id="featured" value="1" {{ old('Featured_Flag') ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured"><i class="bi bi-star-fill text-warning me-1"></i>Mark as Featured Listing</label>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2">
                    <i class="bi bi-plus-circle me-2"></i>Create Listing
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
