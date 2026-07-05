<x-app-layout>
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- ── LEFT: Property Details ─────────────────────────────── -->
            <div class="col-lg-8">
                <!-- Image Gallery -->
                <div class="card card-custom overflow-hidden mb-4">
                    @php $property = $listing->property; @endphp
                    @if($property->images->isNotEmpty())
                        <div id="gallery" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($property->images as $i => $img)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                        <!--<img src="{{ Storage::url($img->Image_Path) }}" class="d-block w-100 object-fit-cover" style="height:380px;" alt="{{ $img->Caption }}">-->
                                        <img src="{{ asset('images/' . $img->Image_Path) }}"
                                        class="d-block w-100 object-fit-cover"
                                        style="height:380px;"
                                        alt="{{ $img->Caption }}">
                                    </div>
                                @endforeach
                            </div>
                            @if($property->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#gallery" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                <button class="carousel-control-next" type="button" data-bs-target="#gallery" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                            @endif
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:300px;">
                            <i class="bi bi-house fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>

                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <span class="badge {{ $listing->Listing_Type=='Sale' ? 'bg-primary-custom' : 'bg-success' }} rounded-pill me-2 fs-6">For {{ $listing->Listing_Type }}</span>
                            <span class="badge {{ $listing->Status=='Active' ? 'bg-success' : 'bg-secondary' }} rounded-pill">{{ $listing->Status }}</span>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary-custom fs-3">Rs. {{ number_format($listing->Price, 0) }}</div>
                            @if($listing->Listing_Type == 'Rent') <div class="text-muted small">/month</div> @endif
                        </div>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $property->Title }}</h2>
                    <p class="text-muted mb-3"><i class="bi bi-geo-alt me-1 text-primary-custom"></i>{{ $property->Location }}, {{ $property->City }}, {{ $property->State }}</p>

                    <div class="row g-3 mb-4">
                        @if($property->Bedrooms > 0)
                        <div class="col-auto"><div class="px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;"><i class="bi bi-door-open text-primary-custom me-2"></i><strong>{{ $property->Bedrooms }}</strong> Beds</div></div>
                        @endif
                        @if($property->Bathrooms > 0)
                        <div class="col-auto"><div class="px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;"><i class="bi bi-droplet text-primary-custom me-2"></i><strong>{{ $property->Bathrooms }}</strong> Baths</div></div>
                        @endif
                        <div class="col-auto"><div class="px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;"><i class="bi bi-arrows-angle-expand text-primary-custom me-2"></i><strong>{{ number_format($property->Area_Size) }}</strong> sqft</div></div>
                        <div class="col-auto"><div class="px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;"><i class="bi bi-eye text-primary-custom me-2"></i><strong>{{ $listing->Total_Views }}</strong> views</div></div>
                    </div>

                    <h5 class="fw-bold mb-2">Listing Description</h5>
                    <p class="text-muted lh-lg">{{ $listing->Description }}</p>

                    @if($property->amenities->isNotEmpty())
                    <h5 class="fw-bold mb-3 mt-4">Amenities</h5>
                    <div class="row g-2">
                        @foreach($property->amenities as $am)
                        <div class="col-6 col-md-4"><div class="d-flex align-items-center gap-2 text-muted small"><i class="bi bi-check-circle-fill text-success"></i>{{ $am->Amenity_Name }}</div></div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Payment Schemes -->
                @if($property->paymentSchemes->isNotEmpty())
                <div class="card card-custom p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-cash-coin me-2 text-primary-custom"></i>Payment Plans</h5>
                    @foreach($property->paymentSchemes as $scheme)
                    <div class="p-3 rounded-3 mb-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold">{{ $scheme->Scheme_Name }}</span>
                            <span class="badge bg-secondary-custom text-primary-custom">{{ $scheme->Scheme_Type }}</span>
                        </div>
                        <p class="text-muted small mb-2">{{ $scheme->Description }}</p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <span><strong>Advance:</strong> {{ $scheme->Advance_Percentage }}%</span>
                            <span><strong>Installments:</strong> {{ $scheme->Installment_Months }} months</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Reviews -->
                <div class="card card-custom p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-star me-2 text-primary-custom"></i>Reviews ({{ $property->reviews->count() }})</h5>
                    @forelse($property->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $review->user->Full_Name ?? 'Anonymous' }}</span>
                            <div>@for($i=1;$i<=5;$i++)<i class="bi {{ $i<=$review->Rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>@endfor</div>
                        </div>
                        <p class="text-muted small mt-1 mb-0">{{ $review->Comment }}</p>
                    </div>
                    @empty
                    <p class="text-muted mb-0">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- ── RIGHT: Sidebar ─────────────────────────────────────── -->
            <div class="col-lg-4">
                <!-- Listing Meta -->
                <div class="card card-custom p-4 mb-4">
                    <h6 class="fw-bold mb-3">Listing Details</h6>
                    <ul class="list-unstyled text-muted small mb-0">
                        <li class="mb-2"><i class="bi bi-calendar3 me-2 text-primary-custom"></i>Listed: {{ $listing->Listing_Date }}</li>
                        <li class="mb-2"><i class="bi bi-calendar-x me-2 text-primary-custom"></i>Expires: {{ $listing->Expire_Date }}</li>
                        @if($listing->Featured_Flag)<li class="mb-2"><i class="bi bi-star-fill me-2 text-warning"></i>Featured Listing</li>@endif
                    </ul>
                </div>

                <!-- Owner/Agent -->
                <div class="card card-custom p-4 mb-4">
                    <h6 class="fw-bold mb-3">Contact</h6>
                    @if($property->agent)
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-circle bg-secondary-custom text-primary-custom d-flex align-items-center justify-content-center fw-bold" style="width:44px;height:44px;">{{ strtoupper(substr($property->agent->user->Full_Name,0,1)) }}</div>
                        <div>
                            <div class="fw-semibold">{{ $property->agent->user->Full_Name }}</div>
                            <div class="text-muted small">Agent · {{ $property->agent->Agency_Name }}</div>
                            <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $property->agent->user->Phone_Number }}</div>
                        </div>
                    </div>
                    @elseif($property->owner)
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-circle bg-secondary-custom text-primary-custom d-flex align-items-center justify-content-center fw-bold" style="width:44px;height:44px;">{{ strtoupper(substr($property->owner->user->Full_Name,0,1)) }}</div>
                        <div>
                            <div class="fw-semibold">{{ $property->owner->user->Full_Name }}</div>
                            <div class="text-muted small">Owner</div>
                            <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $property->owner->user->Phone_Number }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                @auth
                <!-- Favorite -->
                <div class="card card-custom p-4 mb-4">
                    @if($isFavorited)
                        <form action="{{ route('favorites.destroy', \App\Models\Favorite::where('User_ID',auth()->id())->where('Listing_ID',$listing->Listing_ID)->first()?->Favorite_ID) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger w-100"><i class="bi bi-heart-fill me-2"></i>Remove from Favorites</button>
                        </form>
                    @else
                        <form action="{{ route('favorites.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="listing_id" value="{{ $listing->Listing_ID }}">
                            <button class="btn btn-outline-primary-custom w-100"><i class="bi bi-heart me-2"></i>Save to Favorites</button>
                        </form>
                    @endif
                </div>

                <!-- Send Inquiry -->
                <div class="card card-custom p-4 mb-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-primary-custom"></i>Send Inquiry</h6>
                    <form action="{{ route('inquiries.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="listing_id" value="{{ $listing->Listing_ID }}">
                        <textarea name="message" class="form-control mb-3" rows="4" placeholder="I am interested in this listing…" required></textarea>
                        <button class="btn btn-primary-custom w-100">Send Message</button>
                    </form>
                </div>

                <!-- Book a Visit -->
                <div class="card card-custom p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2 text-primary-custom"></i>Book a Visit</h6>
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->Property_ID }}">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Date</label>
                            <input type="date" name="visit_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Time</label>
                            <input type="time" name="visit_time" class="form-control" required>
                        </div>
                        <button class="btn btn-primary-custom w-100">Book Visit</button>
                    </form>
                </div>
                @else
                <div class="card card-custom p-4 text-center">
                    <i class="bi bi-lock fs-2 text-muted mb-2"></i>
                    <p class="text-muted mb-2">Login to save, inquire or book.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary-custom">Login Now</a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
