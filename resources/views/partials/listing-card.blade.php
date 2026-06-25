<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="card card-custom h-100 overflow-hidden">
        <!-- Image / placeholder -->
        <div class="position-relative" style="height:180px;overflow:hidden;background:linear-gradient(135deg,#A6C3E4,#78A3D4);">
            @if($listing->property->images->first())
                <img src="{{ Storage::url($listing->property->images->first()->Image_Path) }}"
                     class="w-100 h-100 object-fit-cover" alt="{{ $listing->property->Title }}">
            @else
                <div class="d-flex align-items-center justify-content-center h-100">
                    <i class="bi bi-house fs-1 text-white opacity-50"></i>
                </div>
            @endif

            <!-- Featured badge -->
            @if($listing->Featured_Flag)
                <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark fw-bold rounded-pill">
                    <i class="bi bi-star-fill me-1"></i>Featured
                </span>
            @endif

            <!-- Listing type badge -->
            <span class="position-absolute top-0 end-0 m-2 badge {{ $listing->Listing_Type == 'Sale' ? 'bg-primary-custom' : 'bg-success' }} rounded-pill fw-semibold">
                For {{ $listing->Listing_Type }}
            </span>
        </div>

        <div class="p-3 d-flex flex-column flex-grow-1">
            <h6 class="fw-bold mb-1 text-truncate">{{ $listing->property->Title }}</h6>
            <p class="text-muted small mb-1">
                <i class="bi bi-geo-alt me-1 text-primary-custom"></i>{{ $listing->property->City }}, {{ $listing->property->State }}
            </p>
            <div class="d-flex gap-3 text-muted small mb-2">
                @if($listing->property->Bedrooms > 0)
                    <span><i class="bi bi-door-open me-1"></i>{{ $listing->property->Bedrooms }} Beds</span>
                @endif
                @if($listing->property->Bathrooms > 0)
                    <span><i class="bi bi-droplet me-1"></i>{{ $listing->property->Bathrooms }} Baths</span>
                @endif
                <span><i class="bi bi-arrows-angle-expand me-1"></i>{{ $listing->property->Area_Size }} sqft</span>
            </div>
            <div class="fw-bold text-primary-custom fs-6 mb-3">
                Rs. {{ number_format($listing->Price, 0) }}
                @if($listing->Listing_Type == 'Rent') <span class="fw-normal text-muted small">/month</span> @endif
            </div>
            <div class="mt-auto">
                <a href="{{ route('listings.show', $listing->Listing_ID) }}" class="btn btn-primary-custom btn-sm w-100">
                    View Details <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
