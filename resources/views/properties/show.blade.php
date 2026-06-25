<x-app-layout>
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- ── LEFT: Images + Details ─────────────────────────────── -->
            <div class="col-lg-8">
                <!-- Image Gallery -->
                <div class="card card-custom overflow-hidden mb-4">
                    @if($property->images->isNotEmpty())
                        <div id="propertyGallery" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($property->images as $i => $img)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                        <img src="{{ Storage::url($img->Image_Path) }}" class="d-block w-100 object-fit-cover" style="height:400px;" alt="{{ $img->Caption }}">
                                    </div>
                                @endforeach
                            </div>
                            @if($property->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#propertyGallery" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#propertyGallery" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-3" style="height:350px;">
                            <i class="bi bi-house fs-1 text-muted"></i>
                        </div>
                    @endif
                </div>

                <!-- Title & Main Info -->
                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <span class="badge bg-secondary-custom text-primary-custom rounded-pill me-2">{{ $property->category->Category_Type ?? 'Property' }}</span>
                            <span class="badge {{ $property->Availability_Status == 'Available' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">{{ $property->Availability_Status }}</span>
                        </div>
                        <h3 class="fw-bold text-primary-custom mb-0">Rs. {{ number_format($property->Price, 0) }}</h3>
                    </div>

                    <h2 class="fw-bold mb-1">{{ $property->Title }}</h2>
                    <p class="text-muted mb-3"><i class="bi bi-geo-alt me-1 text-primary-custom"></i>{{ $property->Location }}, {{ $property->City }}, {{ $property->State }} {{ $property->Zip_Code }}</p>

                    <div class="row g-3 mb-4">
                        @if($property->Bedrooms > 0)
                            <div class="col-auto">
                                <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                                    <i class="bi bi-door-open fs-5 text-primary-custom"></i>
                                    <div><span class="fw-bold">{{ $property->Bedrooms }}</span><br><span class="text-muted small">Bedrooms</span></div>
                                </div>
                            </div>
                        @endif
                        @if($property->Bathrooms > 0)
                            <div class="col-auto">
                                <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                                    <i class="bi bi-droplet fs-5 text-primary-custom"></i>
                                    <div><span class="fw-bold">{{ $property->Bathrooms }}</span><br><span class="text-muted small">Bathrooms</span></div>
                                </div>
                            </div>
                        @endif
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                                <i class="bi bi-arrows-angle-expand fs-5 text-primary-custom"></i>
                                <div><span class="fw-bold">{{ number_format($property->Area_Size) }}</span><br><span class="text-muted small">Sq. Ft.</span></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                                <i class="bi bi-building fs-5 text-primary-custom"></i>
                                <div><span class="fw-bold">{{ $property->Property_Type }}</span><br><span class="text-muted small">Type</span></div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-2">Description</h5>
                    <p class="text-muted lh-lg">{{ $property->Description }}</p>
                </div>

                <!-- Amenities -->
                @if($property->amenities->isNotEmpty())
                    <div class="card card-custom p-4 mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-stars me-2 text-primary-custom"></i>Amenities</h5>
                        <div class="row g-2">
                            @foreach($property->amenities as $amenity)
                                <div class="col-6 col-md-4">
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        {{ $amenity->Amenity_Name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Payment Schemes -->
                @if($property->paymentSchemes->isNotEmpty())
                    <div class="card card-custom p-4 mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-cash-coin me-2 text-primary-custom"></i>Payment Schemes</h5>
                        @foreach($property->paymentSchemes as $scheme)
                            <div class="p-3 rounded-3 mb-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold">{{ $scheme->Scheme_Name }}</span>
                                    <span class="badge bg-secondary-custom text-primary-custom">{{ $scheme->Scheme_Type }}</span>
                                </div>
                                <p class="text-muted small mb-2">{{ $scheme->Description }}</p>
                                <div class="row g-2 text-muted small">
                                    <div class="col-auto"><strong>Advance:</strong> {{ $scheme->Advance_Percentage }}%</div>
                                    <div class="col-auto"><strong>Installments:</strong> {{ $scheme->Installment_Months }} months</div>
                                </div>
                                @auth
                                    @php $advanceAmt = round($property->Price * $scheme->Advance_Percentage / 100); @endphp
                                    <form action="{{ route('payments.store') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="Scheme_ID" value="{{ $scheme->Scheme_ID }}">
                                        <input type="hidden" name="Amount" value="{{ $advanceAmt }}">
                                        <input type="hidden" name="Payment_Method" value="Bank Transfer">
                                        <button type="submit" class="btn btn-sm btn-outline-primary-custom">
                                            <i class="bi bi-wallet2 me-1"></i>Apply – Rs. {{ number_format($advanceAmt,0) }} advance
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Reviews -->
                <div class="card card-custom p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-star me-2 text-primary-custom"></i>Reviews ({{ $property->reviews->count() }})</h5>
                    @forelse($property->reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-semibold">{{ $review->user->Full_Name ?? 'Anonymous' }}</span>
                                    <span class="text-muted small ms-2">{{ $review->Review_Date }}</span>
                                </div>
                                <div>
                                    @for($i=1;$i<=5;$i++)
                                        <i class="bi {{ $i <= $review->Rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted small mt-2 mb-0">{{ $review->Comment }}</p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No reviews yet. Be the first to share your experience!</p>
                    @endforelse
                </div>
            </div>

            <!-- ── RIGHT: Contact / Actions Sidebar ─────────────────────── -->
            <div class="col-lg-4">
                <!-- Owner / Agent Info -->
                <div class="card card-custom p-4 mb-4">
                    <h6 class="fw-bold mb-3">Listed By</h6>
                    @if($property->agent)
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="rounded-circle bg-secondary-custom text-primary-custom d-flex align-items-center justify-content-center fw-bold" style="width:44px;height:44px;">
                                {{ strtoupper(substr($property->agent->user->Full_Name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $property->agent->user->Full_Name }}</div>
                                <div class="text-muted small"><i class="bi bi-person-badge me-1"></i>Agent · {{ $property->agent->Agency_Name }}</div>
                            </div>
                        </div>
                    @elseif($property->owner)
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="rounded-circle bg-secondary-custom text-primary-custom d-flex align-items-center justify-content-center fw-bold" style="width:44px;height:44px;">
                                {{ strtoupper(substr($property->owner->user->Full_Name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $property->owner->user->Full_Name }}</div>
                                <div class="text-muted small"><i class="bi bi-house-check me-1"></i>Owner</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Active Listing Card -->
                @php $activeListing = $property->listings->where('Status','Active')->first(); @endphp
                @if($activeListing)
                    <div class="card card-custom p-4 mb-4" style="border-left:4px solid var(--primary-color);">
                        <h6 class="fw-bold mb-1">Active Listing</h6>
                        <span class="badge {{ $activeListing->Listing_Type=='Sale' ? 'bg-primary-custom' : 'bg-success' }} rounded-pill mb-2">For {{ $activeListing->Listing_Type }}</span>
                        <div class="fw-bold text-primary-custom fs-5">Rs. {{ number_format($activeListing->Price, 0) }}</div>
                        <div class="text-muted small mb-3">Expires: {{ $activeListing->Expire_Date }}</div>
                        <div class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $activeListing->Total_Views }} views</div>
                    </div>
                @endif

                @auth
                    <!-- Favorite -->
                    <div class="card card-custom p-4 mb-4">
                        @if($activeListing)
                            @if($isFavorited)
                                <form action="{{ route('favorites.destroy', \App\Models\Favorite::where('User_ID',auth()->id())->where('Listing_ID',$activeListing->Listing_ID)->first()?->Favorite_ID) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger w-100"><i class="bi bi-heart-fill me-2"></i>Remove from Favorites</button>
                                </form>
                            @else
                                <form action="{{ route('favorites.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="listing_id" value="{{ $activeListing->Listing_ID }}">
                                    <button class="btn btn-outline-primary-custom w-100"><i class="bi bi-heart me-2"></i>Save to Favorites</button>
                                </form>
                            @endif
                        @endif
                    </div>

                    <!-- Send Inquiry -->
                    @if($activeListing)
                    <div class="card card-custom p-4 mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-primary-custom"></i>Send Inquiry</h6>
                        <form action="{{ route('inquiries.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="listing_id" value="{{ $activeListing->Listing_ID }}">
                            <textarea name="message" class="form-control mb-3" rows="4" placeholder="Hi, I'm interested in this property…" required></textarea>
                            <button type="submit" class="btn btn-primary-custom w-100">Send Message</button>
                        </form>
                    </div>
                    @endif

                    <!-- Book a Visit -->
                    <div class="card card-custom p-4 mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2 text-primary-custom"></i>Book a Visit</h6>
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->Property_ID }}">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Visit Date</label>
                                <input type="date" name="visit_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Visit Time</label>
                                <input type="time" name="visit_time" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100">Book Visit</button>
                        </form>
                    </div>
                @else
                    <div class="card card-custom p-4 text-center">
                        <i class="bi bi-lock fs-2 text-muted mb-2"></i>
                        <p class="text-muted mb-2">Login to save, inquire or book a visit.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary-custom">Login Now</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
