<x-app-layout>
    <!-- ─── HERO SECTION ─────────────────────────────────────────────────── -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-secondary-custom text-primary-custom fw-semibold px-3 py-2 rounded-pill mb-3 d-inline-block">
                        <i class="bi bi-geo-alt me-1"></i> Pakistan's #1 Real Estate Platform
                    </span>
                    <h1 class="display-4 fw-bold mb-4" style="line-height:1.2;">
                        Find Your Perfect <span class="text-primary-custom">Property</span> Today
                    </h1>
                    <p class="lead text-muted mb-5">
                        Discover thousands of properties for sale and rent across Pakistan. Connect with trusted owners and agents instantly.
                    </p>

                    <!-- Search bar -->
                    <form action="{{ route('properties.search') }}" method="GET">
                        <div class="card card-custom shadow-sm p-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-muted text-uppercase">City</label>
                                    <input type="text" name="city" class="form-control border-0 bg-light" placeholder="Lahore, Karachi…">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase">Type</label>
                                    <select name="type" class="form-select border-0 bg-light">
                                        <option value="">Any Type</option>
                                        <option value="House">House</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Office">Office</option>
                                        <option value="Shop">Shop</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold text-muted text-uppercase">Purpose</label>
                                    <select name="listing_type" class="form-select border-0 bg-light">
                                        <option value="">Buy or Rent</option>
                                        <option value="Sale">Buy</option>
                                        <option value="Rent">Rent</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">
                                        <i class="bi bi-search me-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    <div class="position-relative">
                        <div class="rounded-4 overflow-hidden shadow-lg" style="width:380px;height:300px;">
                            <img src="{{ asset('images/image7.jpeg') }}" alt="RealEstate" class="w-100 h-100" style="object-fit:cover;">
                        </div>
                        <!-- Stats badge -->
                        <div class="card card-custom p-3 shadow-lg position-absolute" style="bottom:-20px;left:-20px;min-width:150px;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle p-2 text-primary-custom"><i class="bi bi-house-check fs-5"></i></div>
                                <div>
                                    <div class="fw-bold fs-5 mb-0 text-primary-custom">{{ \App\Models\Property::count() }}+</div>
                                    <div class="text-muted small">Properties Listed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FEATURED LISTINGS ─────────────────────────────────────────────── -->
    @if($featuredListings->count())
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Featured Properties</h2>
                    <p class="text-muted mb-0">Handpicked premium listings just for you</p>
                </div>
                <a href="{{ route('properties.search') }}" class="btn btn-outline-primary-custom">View All <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                @foreach($featuredListings as $listing)
                    @include('partials.listing-card', ['listing' => $listing])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── LATEST LISTINGS ───────────────────────────────────────────────── -->
    @if($latestListings->count())
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Latest Listings</h2>
                    <p class="text-muted mb-0">Fresh properties added this week</p>
                </div>
                <a href="{{ route('properties.search') }}?sort=newest" class="btn btn-outline-primary-custom">Browse More <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                @foreach($latestListings as $listing)
                    @include('partials.listing-card', ['listing' => $listing])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── POPULAR CATEGORIES ────────────────────────────────────────────── -->
    @if($categories->count())
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-1">Browse by Category</h2>
                <p class="text-muted">Explore properties by type</p>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach($categories as $cat)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('properties.search') }}?category_id={{ $cat->Category_ID }}" class="text-decoration-none">
                        <div class="card card-custom text-center p-4 h-100">
                            <div class="fs-2 text-primary-custom mb-2">
                                @if(str_contains(strtolower($cat->Category_Type), 'house')) <i class="bi bi-house-door"></i>
                                @elseif(str_contains(strtolower($cat->Category_Type), 'apartment')) <i class="bi bi-building"></i>
                                @elseif(str_contains(strtolower($cat->Category_Type), 'office')) <i class="bi bi-briefcase"></i>
                                @elseif(str_contains(strtolower($cat->Category_Type), 'shop')) <i class="bi bi-shop"></i>
                                @else <i class="bi bi-geo"></i>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $cat->Category_Name }}</h6>
                            <span class="text-muted small">{{ $cat->Category_Type }}</span>
                            <div class="mt-2 badge bg-secondary-custom text-primary-custom rounded-pill">{{ $cat->properties_count }} props</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── POPULAR CITIES ────────────────────────────────────────────────── -->
    @if($popularCities->count())
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-1">Popular Cities</h2>
                <p class="text-muted">Find properties in major Pakistani cities</p>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach($popularCities as $city)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('properties.search') }}?city={{ $city->City }}" class="text-decoration-none">
                        <div class="card card-custom text-center p-4 h-100">
                            <i class="bi bi-pin-map fs-2 text-primary-custom mb-2"></i>
                            <h6 class="fw-bold mb-0 text-dark">{{ $city->City }}</h6>
                            <span class="text-muted small">{{ $city->property_count }} properties</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── WHY CHOOSE US ─────────────────────────────────────────────────── -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-1">Why Choose RealEstate?</h2>
                <p class="text-muted">Everything you need in one trusted platform</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100">
                        <div class="fs-1 text-primary-custom mb-3"><i class="bi bi-shield-check"></i></div>
                        <h5 class="fw-bold">Verified Listings</h5>
                        <p class="text-muted mb-0">Every property is verified by our team to ensure authenticity and accuracy.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100">
                        <div class="fs-1 text-primary-custom mb-3"><i class="bi bi-person-badge"></i></div>
                        <h5 class="fw-bold">Trusted Agents</h5>
                        <p class="text-muted mb-0">Connect with licensed and experienced real estate agents across Pakistan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100">
                        <div class="fs-1 text-primary-custom mb-3"><i class="bi bi-cash-coin"></i></div>
                        <h5 class="fw-bold">Flexible Payments</h5>
                        <p class="text-muted mb-0">Multiple payment schemes and installment plans to suit every budget.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FOOTER ────────────────────────────────────────────────────────── -->
    <footer class="py-5 mt-auto" style="background-color:#1F2937;color:#f8fafc;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3 text-white"><i class="bi bi-houses-fill me-2 text-primary-custom"></i>RealEstate</h5>
                    <p class="small mb-0" style="color:#cbd5e1;">Pakistan's premier real estate platform connecting buyers, sellers, renters and agents since 2025.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><a href="/" class="text-decoration-none small" style="color:#cbd5e1;">Home</a></li>
                        <li class="mb-1"><a href="{{ route('properties.search') }}" class="text-decoration-none small" style="color:#cbd5e1;">Browse Properties</a></li>
                        @auth
                        <li class="mb-1"><a href="{{ route('dashboard') }}" class="text-decoration-none small" style="color:#cbd5e1;">Dashboard</a></li>
                        @else
                        <li class="mb-1"><a href="{{ route('register') }}" class="text-decoration-none small" style="color:#cbd5e1;">Register</a></li>
                        <li class="mb-1"><a href="{{ route('login') }}" class="text-decoration-none small" style="color:#cbd5e1;">Login</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-3">Contact</h6>
                    <ul class="list-unstyled mb-0 small" style="color:#cbd5e1;">
                        <li class="mb-1"><i class="bi bi-envelope me-2 text-primary-custom"></i>info@realestate.pk</li>
                        <li class="mb-1"><i class="bi bi-telephone me-2 text-primary-custom"></i>+92 300 1234567</li>
                        <li class="mb-1"><i class="bi bi-geo-alt me-2 text-primary-custom"></i>Lahore, Punjab, Pakistan</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center small" style="color:#cbd5e1;">
                &copy; {{ date('Y') }} RealEstate Listing Platform. All rights reserved.
            </div>
        </div>
    </footer>
</x-app-layout>
