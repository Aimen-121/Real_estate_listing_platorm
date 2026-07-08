<x-app-layout>
    <div class="container py-5" style="max-width:760px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('properties.show', $property->Property_ID) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
            <h3 class="fw-bold mb-0">Edit Property</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('properties.update', $property->Property_ID) }}" method="POST">
            @csrf @method('PATCH')

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary-custom"></i>Basic Information</h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Property Title <span class="text-danger">*</span></label>
                    <input type="text" name="Title" class="form-control" value="{{ old('Title', $property->Title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea name="Description" class="form-control" rows="4" required>{{ old('Description', $property->Description) }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="Category_ID" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->Category_ID }}" {{ old('Category_ID', $property->Category_ID) == $cat->Category_ID ? 'selected' : '' }}>
                                    {{ $cat->Category_Name }} ({{ $cat->Category_Type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Property Type <span class="text-danger">*</span></label>
                        <select name="Property_Type" class="form-select" required>
                            @foreach(['House','Apartment','Office','Shop','Plot','Farmhouse'] as $t)
                                <option value="{{ $t }}" {{ old('Property_Type', $property->Property_Type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-primary-custom"></i>Location</h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Street / Area <span class="text-danger">*</span></label>
                    <input type="text" name="Location" class="form-control" value="{{ old('Location', $property->Location) }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                        <input type="text" name="City" class="form-control" value="{{ old('City', $property->City) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                        <input type="text" name="State" class="form-control" value="{{ old('State', $property->State) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Zip Code</label>
                        <input type="text" name="Zip_Code" class="form-control" value="{{ old('Zip_Code', $property->Zip_Code) }}">
                    </div>
                </div>
            </div>

            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-rulers me-2 text-primary-custom"></i>Property Details</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Area Size (sqft) <span class="text-danger">*</span></label>
                        <input type="number" name="Area_Size" class="form-control" value="{{ old('Area_Size', $property->Area_Size) }}" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="Bedrooms" class="form-control" value="{{ old('Bedrooms', $property->Bedrooms) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bathrooms</label>
                        <input type="number" name="Bathrooms" class="form-control" value="{{ old('Bathrooms', $property->Bathrooms) }}" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="Price" class="form-control" value="{{ old('Price', $property->Price) }}" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Availability Status <span class="text-danger">*</span></label>
                        <select name="Availability_Status" class="form-select" required>
                            @foreach(['Available','Rented','Sold'] as $s)
                                <option value="{{ $s }}" {{ old('Availability_Status', $property->Availability_Status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @if($amenities->isNotEmpty())
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-stars me-2 text-primary-custom"></i>Amenities</h5>
                @php $selectedAmenities = old('amenities', $property->amenities->pluck('Amenity_ID')->toArray()); @endphp
                <div class="row g-2">
                    @foreach($amenities as $amenity)
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->Amenity_ID }}" id="ame_{{ $amenity->Amenity_ID }}" {{ in_array($amenity->Amenity_ID, $selectedAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ame_{{ $amenity->Amenity_ID }}">{{ $amenity->Amenity_Name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Close Update Form before Existing Images / uploading images -->
<button type="submit" class="btn btn-primary-custom px-5 py-2 mb-4">
    <i class="bi bi-check-circle me-2"></i>Save Changes
</button>

</form>

<!-- Existing Images (kept OUTSIDE the edit form above — a <form> cannot be nested inside another <form>,
     which is what was previously breaking the Upload Images form below) -->
@if($property->images->isNotEmpty())
<div class="card card-custom p-4 mb-4">
    <h5 class="fw-bold mb-3"><i class="bi bi-images me-2 text-primary-custom"></i>Existing Images</h5>
    <div class="row g-2">
        @foreach($property->images as $img)
            <div class="col-4 col-md-3 position-relative">
                <img src="{{ asset('images/'.$img->Image_Path) }}" class="w-100 rounded-3 object-fit-cover" style="height:90px;" alt="{{ $img->Caption }}">
                <form action="{{ route('properties.images.destroy', [$property->Property_ID, $img->Image_ID]) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0" style="width:22px;height:22px;line-height:1;"
                        onclick="return confirm('Delete this image?')">×</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Upload New Images -->
<div class="card card-custom p-4 mb-4">

    <h5 class="fw-bold mb-3">
        <i class="bi bi-cloud-upload me-2 text-primary-custom"></i>
        Add More Images
    </h5>

    <form action="{{ route('properties.images.upload', $property->Property_ID) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <input type="file"
               name="images[]"
               class="form-control mb-3"
               multiple
               accept="image/*">

        <button type="submit" class="btn btn-outline-primary-custom btn-sm">
            Upload Images
        </button>

    </form>

</div>

            
    </div>
</x-app-layout>
