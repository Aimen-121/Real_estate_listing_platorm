<x-app-layout>
    <div class="container py-5" style="max-width:680px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
            <h3 class="fw-bold mb-0">Edit Listing</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card card-custom p-4">
            <form action="{{ route('listings.update', $listing->Listing_ID) }}" method="POST">
                @csrf @method('PATCH')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Property</label>
                    <input type="text" class="form-control bg-light" value="{{ $listing->property->Title ?? 'N/A' }}" disabled>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Listing Type <span class="text-danger">*</span></label>
                        <select name="Listing_Type" class="form-select" required>
                            <option value="Sale" {{ old('Listing_Type',$listing->Listing_Type) == 'Sale' ? 'selected' : '' }}>For Sale</option>
                            <option value="Rent" {{ old('Listing_Type',$listing->Listing_Type) == 'Rent' ? 'selected' : '' }}>For Rent</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="Price" class="form-control" value="{{ old('Price',$listing->Price) }}" min="0" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Expiry Date <span class="text-danger">*</span></label>
                        <input type="date" name="Expire_Date" class="form-control" value="{{ old('Expire_Date',$listing->Expire_Date) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="Status" class="form-select" required>
                            @foreach(['Active','Inactive','Expired'] as $s)
                                <option value="{{ $s }}" {{ old('Status',$listing->Status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea name="Description" class="form-control" rows="4" required>{{ old('Description',$listing->Description) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="Featured_Flag" id="featured" value="1" {{ old('Featured_Flag',$listing->Featured_Flag) ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured"><i class="bi bi-star-fill text-warning me-1"></i>Featured Listing</label>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
