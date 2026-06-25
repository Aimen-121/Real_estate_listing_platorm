<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <!-- ── FILTER SIDEBAR ───────────────────────────────────────── -->
            <div class="col-lg-3 mb-4">
                <div class="card card-custom p-4 sticky-top" style="top:80px;">
                    <h5 class="fw-bold mb-4"><i class="bi bi-funnel me-2 text-primary-custom"></i>Filter Properties</h5>
                    <form action="{{ route('properties.search') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">City</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Lahore" value="{{ request('city') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->Category_ID }}" {{ request('category_id') == $cat->Category_ID ? 'selected' : '' }}>
                                        {{ $cat->Category_Name }} – {{ $cat->Category_Type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Property Type</label>
                            <select name="type" class="form-select">
                                <option value="">Any Type</option>
                                @foreach(['House','Apartment','Office','Shop','Plot','Farmhouse'] as $t)
                                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Availability</label>
                            <select name="availability" class="form-select">
                                <option value="">Any</option>
                                <option value="Available" {{ request('availability') == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Rented" {{ request('availability') == 'Rented' ? 'selected' : '' }}>Rented</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Min Price (Rs.)</label>
                            <input type="number" name="min_price" class="form-control" placeholder="0" value="{{ request('min_price') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Max Price (Rs.)</label>
                            <input type="number" name="max_price" class="form-control" placeholder="Any" value="{{ request('max_price') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Min Bedrooms</label>
                            <select name="bedrooms" class="form-select">
                                <option value="">Any</option>
                                @foreach([1,2,3,4,5] as $b)
                                    <option value="{{ $b }}" {{ request('bedrooms') == $b ? 'selected' : '' }}>{{ $b }}+</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">Apply Filters</button>
                        <a href="{{ route('properties.search') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                    </form>
                </div>
            </div>

            <!-- ── RESULTS ──────────────────────────────────────────────── -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <span class="text-primary-custom">{{ $properties->total() }}</span> Properties Found
                        @if(request('city')) <span class="text-muted fw-normal fs-6">in "{{ request('city') }}"</span> @endif
                    </h5>
                </div>

                @if($properties->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                        <h5 class="fw-bold">No properties found</h5>
                        <p class="text-muted">Try adjusting your filters or <a href="{{ route('properties.search') }}">browse all properties</a>.</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($properties as $property)
                            @php
                                $listing = $property->listings->where('Status','Active')->first();
                                $mainImg = $property->images->first();
                            @endphp
                            <div class="col-sm-6 col-md-4">
                                <div class="card card-custom h-100 overflow-hidden">
                                    <div class="position-relative" style="height:175px;overflow:hidden;background:linear-gradient(135deg,#A6C3E4,#78A3D4);">
                                        @if($mainImg)
                                            <img src="{{ Storage::url($mainImg->Image_Path) }}" class="w-100 h-100 object-fit-cover" alt="{{ $property->Title }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="bi bi-house fs-1 text-white opacity-50"></i>
                                            </div>
                                        @endif
                                        @if($listing)
                                            <span class="position-absolute top-0 end-0 m-2 badge {{ $listing->Listing_Type=='Sale' ? 'bg-primary-custom' : 'bg-success' }} rounded-pill">For {{ $listing->Listing_Type }}</span>
                                        @endif
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <span class="text-muted small mb-1">{{ $property->category->Category_Type ?? '' }}</span>
                                        <h6 class="fw-bold mb-1 text-truncate">{{ $property->Title }}</h6>
                                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt me-1 text-primary-custom"></i>{{ $property->Location }}, {{ $property->City }}</p>
                                        <div class="d-flex gap-3 text-muted small mb-2">
                                            @if($property->Bedrooms > 0)<span><i class="bi bi-door-open me-1"></i>{{ $property->Bedrooms }}</span>@endif
                                            @if($property->Bathrooms > 0)<span><i class="bi bi-droplet me-1"></i>{{ $property->Bathrooms }}</span>@endif
                                            <span><i class="bi bi-arrows-angle-expand me-1"></i>{{ number_format($property->Area_Size) }} sqft</span>
                                        </div>
                                        <div class="fw-bold text-primary-custom mb-3">Rs. {{ number_format($property->Price, 0) }}</div>
                                        <div class="mt-auto">
                                            <a href="{{ route('properties.show', $property->Property_ID) }}" class="btn btn-primary-custom btn-sm w-100">View Details <i class="bi bi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
