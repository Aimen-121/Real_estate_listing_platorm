<x-app-layout>
    <div class="container py-5" style="max-width:760px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('dashboard', ['view'=>'Owner']) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
            <h3 class="fw-bold mb-0">Add New Property</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary-custom"></i>Basic Information</h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Property Title <span class="text-danger">*</span></label>
                    <input type="text" name="Title" class="form-control" value="{{ old('Title') }}" placeholder="e.g. Spacious 3-Bedroom House in Gulberg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea name="Description" class="form-control" rows="4" placeholder="Describe your property in detail…" required>{{ old('Description') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="Category_ID" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->Category_ID }}" {{ old('Category_ID') == $cat->Category_ID ? 'selected' : '' }}>
                                    {{ $cat->Category_Name }} ({{ $cat->Category_Type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Property Type <span class="text-danger">*</span></label>
                        <select name="Property_Type" class="form-select" required>
                            @foreach(['House','Apartment','Office','Shop','Plot','Farmhouse'] as $t)
                                <option value="{{ $t }}" {{ old('Property_Type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-primary-custom"></i>Location</h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Street / Area <span class="text-danger">*</span></label>
                    <input type="text" name="Location" class="form-control" value="{{ old('Location') }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                        <input type="text" name="City" class="form-control" value="{{ old('City') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                        <input type="text" name="State" class="form-control" value="{{ old('State') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Zip Code</label>
                        <input type="text" name="Zip_Code" class="form-control" value="{{ old('Zip_Code') }}">
                    </div>
                </div>
            </div>

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-rulers me-2 text-primary-custom"></i>Property Details</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Area Size (sqft) <span class="text-danger">*</span></label>
                        <input type="number" name="Area_Size" class="form-control" value="{{ old('Area_Size') }}" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="Bedrooms" class="form-control" value="{{ old('Bedrooms', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bathrooms</label>
                        <input type="number" name="Bathrooms" class="form-control" value="{{ old('Bathrooms', 0) }}" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="Price" class="form-control" value="{{ old('Price') }}" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Availability Status <span class="text-danger">*</span></label>
                        <select name="Availability_Status" class="form-select" required>
                            <option value="Available" {{ old('Availability_Status','Available') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Rented" {{ old('Availability_Status') == 'Rented' ? 'selected' : '' }}>Rented</option>
                            <option value="Sold" {{ old('Availability_Status') == 'Sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($amenities->isNotEmpty())
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-stars me-2 text-primary-custom"></i>Amenities</h5>
                <div class="row g-2">
                    @foreach($amenities as $amenity)
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->Amenity_ID }}" id="am_{{ $amenity->Amenity_ID }}" {{ in_array($amenity->Amenity_ID, old('amenities', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="am_{{ $amenity->Amenity_ID }}">{{ $amenity->Amenity_Name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-images me-2 text-primary-custom"></i>Property Images</h5>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                <div class="form-text">Upload up to 10 images (JPEG, PNG, GIF, max 2MB each).</div>
            </div>

            <button type="submit" class="btn btn-primary-custom px-5 py-2">
                <i class="bi bi-plus-circle me-2"></i>Add Property
            </button>
        </form>
    </div>
</x-app-layout>
