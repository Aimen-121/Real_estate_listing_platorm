<x-app-layout>
    <div class="container py-5">
        @php
            $roles = $user->getRoles();
            $activeRole = request('view', reset($roles));
        @endphp

        <!-- Welcome Banner -->
        <div class="page-header-banner shadow-sm mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1 text-primary-custom">Hello, {{ $user->Full_Name }}!</h2>
                    <p class="text-muted mb-0">Welcome to your dashboard. You have the following active roles: 
                        @foreach($roles as $role)
                            <span class="badge bg-secondary-custom text-primary-custom rounded-pill px-2.5 py-1.5 fw-semibold">{{ $role }}</span>
                        @endforeach
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <p class="text-muted small mb-0"><i class="bi bi-calendar3 me-1 text-primary-custom"></i> Member since {{ $user->Registration_Date ? $user->Registration_Date->format('M d, Y') : 'N/A' }}</p>
                    <p class="text-muted small mb-0"><i class="bi bi-shield-check me-1 text-primary-custom"></i> Account Status: <strong>{{ $user->Status }}</strong></p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Role View Switcher -->
        @if(count($roles) > 1)
            <ul class="nav nav-pills mb-4 gap-2">
                @foreach($roles as $role)
                    <li class="nav-item">
                        <a class="nav-link {{ $activeRole == $role ? 'active bg-primary-custom text-white' : 'bg-white border text-dark' }} fw-bold rounded-pill px-4" href="?view={{ $role }}">
                            @if($role == 'Admin') <i class="bi bi-shield-lock me-1"></i>
                            @elseif($role == 'Owner') <i class="bi bi-house-heart me-1"></i>
                            @elseif($role == 'Agent') <i class="bi bi-person-badge me-1"></i>
                            @elseif($role == 'Buyer') <i class="bi bi-cart3 me-1"></i>
                            @elseif($role == 'Renter') <i class="bi bi-key me-1"></i>
                            @endif
                            {{ $role }} Dashboard
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- ==================== ADMIN DASHBOARD ==================== -->
        @if($activeRole == 'Admin' && $user->isAdmin())
            <div class="card card-custom p-4 mb-4 text-center border-0 shadow-sm">
                <div class="py-4">
                    <i class="bi bi-shield-lock-fill text-primary-custom" style="font-size: 3rem;"></i>
                    <h4 class="fw-bold mt-3">Welcome to the Administration Console</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 600px;">
                        As an administrator, you have access to the system configuration, users, listings, payments, bookings, and categories. Click the button below to open the interactive Admin Panel.
                    </p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary-custom px-5 py-2.5 fw-bold text-uppercase">
                        <i class="bi bi-speedometer2 me-2"></i>Open Admin Panel
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-custom stat-card h-100 p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Users</h6>
                                <h3 class="fw-bold mb-0">{{ $data['admin']['total_users'] }}</h3>
                            </div>
                            <div class="bg-light p-3 rounded-3 text-primary-custom"><i class="bi bi-people fs-4"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-custom stat-card h-100 p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Properties</h6>
                                <h3 class="fw-bold mb-0">{{ $data['admin']['total_properties'] }}</h3>
                            </div>
                            <div class="bg-light p-3 rounded-3 text-primary-custom"><i class="bi bi-building fs-4"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-custom stat-card h-100 p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Listings</h6>
                                <h3 class="fw-bold mb-0">{{ $data['admin']['total_listings'] }}</h3>
                            </div>
                            <div class="bg-light p-3 rounded-3 text-primary-custom"><i class="bi bi-card-list fs-4"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-custom stat-card h-100 p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Revenue</h6>
                                <h3 class="fw-bold mb-0">Rs. {{ number_format($data['admin']['total_revenue']) }}</h3>
                            </div>
                            <div class="bg-light p-3 rounded-3 text-primary-custom"><i class="bi bi-cash-stack fs-4"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Tables -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-person-plus me-2 text-primary-custom"></i>Recent Registrations</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['admin']['recent_users'] as $u)
                                        <tr>
                                            <td class="fw-semibold">{{ $u->Full_Name }}</td>
                                            <td>{{ $u->Email }}</td>
                                            <td><span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1">{{ $u->Status }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary-custom"></i>Recent Transactions</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['admin']['recent_payments'] as $p)
                                        <tr>
                                            <td class="fw-semibold">{{ $p->user->Full_Name }}</td>
                                            <td>Rs. {{ number_format($p->Amount, 2) }}</td>
                                            <td>{{ $p->Payment_Method }}</td>
                                            <td>
                                                <span class="badge {{ $p->Payment_Status == 'Completed' ? 'bg-success' : 'bg-warning' }} rounded-pill px-2.5 py-1">
                                                    {{ $p->Payment_Status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ==================== OWNER DASHBOARD ==================== -->
        @elseif($activeRole == 'Owner' && $user->isOwner())
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">Properties & Listings Management</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('properties.create') }}" class="btn btn-primary-custom"><i class="bi bi-plus-lg me-1"></i> Add Property</a>
                    <a href="{{ route('listings.create') }}" class="btn btn-secondary-custom"><i class="bi bi-plus-lg me-1"></i> Create Listing</a>
                </div>
            </div>

            <!-- Properties Table -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-building me-2 text-primary-custom"></i>My Properties</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['owner']['properties'] as $prop)
                                <tr>
                                    <td class="fw-semibold">{{ $prop->Title }}</td>
                                    <td>{{ $prop->Location }}, {{ $prop->City }}</td>
                                    <td>{{ $prop->Property_Type }}</td>
                                    <td>Rs. {{ number_format($prop->Price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $prop->Availability_Status == 'Available' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-2 py-1">
                                            {{ $prop->Availability_Status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('properties.show', $prop->Property_ID) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('properties.edit', $prop->Property_ID) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('properties.destroy', $prop->Property_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No properties found. Add your first property above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Listings Table -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-card-list me-2 text-primary-custom"></i>My Active Listings</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Listing ID</th>
                                <th>Property</th>
                                <th>Listing Type</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['owner']['listings'] as $list)
                                <tr>
                                    <td>#{{ $list->Listing_ID }}</td>
                                    <td class="fw-semibold">{{ $list->property->Title ?? 'N/A' }}</td>
                                    <td><span class="badge bg-secondary-custom text-primary-custom">{{ $list->Listing_Type }}</span></td>
                                    <td>Rs. {{ number_format($list->Price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $list->Status == 'Active' ? 'bg-success' : 'bg-warning' }} rounded-pill px-2.5 py-1">
                                            {{ $list->Status }}
                                        </span>
                                    </td>
                                    <td><i class="bi bi-eye me-1"></i> {{ $list->Total_Views }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('listings.edit', $list->Listing_ID) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                            <form action="{{ route('listings.toggle', $list->Listing_ID) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $list->Status == 'Active' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                                    {{ $list->Status == 'Active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('listings.destroy', $list->Listing_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No listings found. Create a listing for your property.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inquiries & Bookings -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-primary-custom"></i>Inquiries on My Listings</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['owner']['inquiries'] as $inq)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $inq->user->Full_Name }}</h6>
                                        <span class="badge {{ $inq->Inquiry_Status == 'Open' ? 'bg-info' : 'bg-secondary' }} rounded-pill px-2.5">{{ $inq->Inquiry_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">On: {{ $inq->listing->property->Title ?? 'Deleted Listing' }} ({{ $inq->Inquiry_Date->format('M d, Y') }})</p>
                                    <p class="mb-2 text-dark bg-light p-2.5 rounded-3 border-start border-primary border-3">{{ $inq->Message }}</p>
                                    <a href="{{ route('inquiries.show', $inq->Inquiry_ID) }}" class="btn btn-sm btn-primary-custom px-3">View & Reply</a>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No inquiries received.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-calendar-event me-2 text-primary-custom"></i>Visits Scheduled (Bookings)</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['owner']['bookings'] as $book)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $book->user->Full_Name }}</h6>
                                        <span class="badge {{ $book->Booking_Status == 'Confirmed' ? 'bg-success' : 'bg-warning' }} rounded-pill">{{ $book->Booking_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">Property: <strong>{{ $book->property->Title ?? 'N/A' }}</strong></p>
                                    <p class="small text-dark mb-2">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $book->Visit_Date->format('M d, Y') }} at <i class="bi bi-clock me-1 ms-2"></i> {{ $book->Visit_Time }}
                                    </p>
                                    @if($book->Booking_Status == 'Pending')
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('bookings.confirm', $book->Booking_ID) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success px-3">Confirm</button>
                                            </form>
                                            <form action="{{ route('bookings.cancel', $book->Booking_ID) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-3">Cancel</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No visits scheduled.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        <!-- ==================== AGENT DASHBOARD ==================== -->
        @elseif($activeRole == 'Agent' && $user->isAgent())
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-buildings-fill me-2 text-primary-custom"></i>My Assigned Properties & Listings</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Property Title</th>
                                <th>City</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Active Listing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['agent']['properties'] as $prop)
                                <tr>
                                    <td class="fw-semibold">{{ $prop->Title }}</td>
                                    <td>{{ $prop->City }}</td>
                                    <td>Rs. {{ number_format($prop->Price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $prop->Availability_Status == 'Available' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            {{ $prop->Availability_Status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($prop->listings->count() > 0)
                                            <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Yes (#{{ $prop->listings->first()->Listing_ID }})</span>
                                        @else
                                            <span class="text-muted"><i class="bi bi-x-circle me-1"></i>No</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No assigned properties found. Contact owners to link your license!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Agent Visits & Inquiries -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2 text-primary-custom"></i>Assigned Visits</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['agent']['bookings'] as $book)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $book->user->Full_Name }}</h6>
                                        <span class="badge {{ $book->Booking_Status == 'Confirmed' ? 'bg-success' : 'bg-warning' }}">{{ $book->Booking_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-1">Property: {{ $book->property->Title ?? 'N/A' }}</p>
                                    <p class="text-muted small mb-2">Owner: {{ $book->owner->user->Full_Name ?? 'N/A' }}</p>
                                    <p class="small text-dark mb-2">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $book->Visit_Date->format('M d, Y') }} at <i class="bi bi-clock me-1 ms-2"></i> {{ $book->Visit_Time }}
                                    </p>
                                    @if($book->Booking_Status == 'Confirmed')
                                        <form action="{{ route('bookings.complete', $book->Booking_ID) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary-custom">Mark Completed</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No visits assigned.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-left-text me-2 text-primary-custom"></i>Client Inquiries</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['agent']['inquiries'] as $inq)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $inq->user->Full_Name }}</h6>
                                        <span class="badge {{ $inq->Inquiry_Status == 'Open' ? 'bg-info' : 'bg-secondary' }}">{{ $inq->Inquiry_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">On listing: {{ $inq->listing->property->Title ?? 'N/A' }}</p>
                                    <p class="mb-2 text-dark bg-light p-2.5 rounded-3">{{ $inq->Message }}</p>
                                    <a href="{{ route('inquiries.show', $inq->Inquiry_ID) }}" class="btn btn-sm btn-primary-custom">Respond</a>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No inquiries received.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        <!-- ==================== BUYER DASHBOARD ==================== -->
        @elseif($activeRole == 'Buyer' && $user->isBuyer())
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">Buyer Hub</h4>
                <a href="{{ route('properties.search') }}" class="btn btn-primary-custom"><i class="bi bi-search me-1"></i> Browse Properties</a>
            </div>

            <!-- Favorites Grid -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-heart-fill me-2 text-danger"></i>My Favorites</h5>
                <div class="row g-4">
                    @forelse($data['buyer']['favorites'] as $fav)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border rounded-3 overflow-hidden shadow-sm">
                                <div class="bg-secondary-custom text-center py-4 text-primary-custom" style="min-height: 120px;">
                                    <i class="bi bi-house fs-1"></i>
                                </div>
                                <div class="p-3">
                                    <h6 class="fw-bold text-truncate mb-1">{{ $fav->listing->property->Title ?? 'N/A' }}</h6>
                                    <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i> {{ $fav->listing->property->City ?? 'N/A' }}</p>
                                    <p class="fw-bold text-primary-custom mb-3">Rs. {{ number_format($fav->listing->Price ?? 0, 2) }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('listings.show', $fav->listing->Listing_ID) }}" class="btn btn-sm btn-primary-custom flex-grow-1">View</a>
                                        <form action="{{ route('favorites.destroy', $fav->Favorite_ID) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-heartbreak"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">No favorite listings saved yet. Browse and hit the heart icon!</div>
                    @endforelse
                </div>
            </div>

            <!-- Inquiries & Bookings -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-primary-custom"></i>My Inquiries Sent</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['buyer']['inquiries'] as $inq)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-truncate text-dark" style="max-width: 70%;">{{ $inq->listing->property->Title ?? 'N/A' }}</h6>
                                        <span class="badge bg-light text-primary-custom border rounded-pill">{{ $inq->Inquiry_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">Sent on: {{ $inq->Inquiry_Date->format('M d, Y') }}</p>
                                    <p class="mb-0 text-dark bg-light p-2.5 rounded-3">{{ $inq->Message }}</p>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No inquiries sent.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-calendar2-check me-2 text-primary-custom"></i>My Visited Visits (Bookings)</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['buyer']['bookings'] as $book)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0 text-dark text-truncate" style="max-width: 70%;">{{ $book->property->Title ?? 'N/A' }}</h6>
                                        <span class="badge bg-secondary-custom text-primary-custom rounded-pill">{{ $book->Booking_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        Date: {{ $book->Visit_Date->format('M d, Y') }} at {{ $book->Visit_Time }}
                                    </p>
                                    <p class="small mb-2">Agent: {{ $book->agent->user->Full_Name ?? 'No Agent Assigned' }}</p>
                                    
                                    @if($book->Booking_Status == 'Completed' && !$user->reviews()->where('Property_ID', $book->Property_ID)->exists())
                                        <a href="{{ route('reviews.create', ['property_id' => $book->Property_ID, 'booking_id' => $book->Booking_ID]) }}" class="btn btn-sm btn-outline-primary-custom">Leave a Review</a>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No visits booked.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        <!-- ==================== RENTER DASHBOARD ==================== -->
        @elseif($activeRole == 'Renter' && $user->isRenter())
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">Renter Hub</h4>
                <a href="{{ route('properties.search') }}?type=Rent" class="btn btn-primary-custom"><i class="bi bi-search me-1"></i> Search Rentals</a>
            </div>

            <!-- Renter Bookings & Favorites -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-heart-fill me-2 text-danger"></i>Favorite Rental Listings</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['renter']['favorites'] as $fav)
                                @if($fav->listing->Listing_Type == 'Rent')
                                    <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $fav->listing->property->Title ?? 'N/A' }}</h6>
                                            <p class="text-muted mb-0 small"><i class="bi bi-geo-alt"></i> {{ $fav->listing->property->City }} • Rs. {{ number_format($fav->listing->Price, 2) }}/month</p>
                                        </div>
                                        <a href="{{ route('listings.show', $fav->listing->Listing_ID) }}" class="btn btn-sm btn-primary-custom">View</a>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-4 text-muted">No rental favorites.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-calendar2-week me-2 text-primary-custom"></i>My Rental Bookings</h5>
                        <div class="list-group list-group-flush">
                            @forelse($data['renter']['bookings'] as $book)
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <h6 class="fw-bold mb-0">{{ $book->property->Title ?? 'N/A' }}</h6>
                                        <span class="badge bg-secondary-custom text-primary-custom rounded-pill">{{ $book->Booking_Status }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">Visit Scheduled: {{ $book->Visit_Date->format('M d, Y') }} at {{ $book->Visit_Time }}</p>
                                    @if($book->Booking_Status == 'Completed' && !$user->reviews()->where('Property_ID', $book->Property_ID)->exists())
                                        <a href="{{ route('reviews.create', ['property_id' => $book->Property_ID, 'booking_id' => $book->Booking_ID]) }}" class="btn btn-sm btn-outline-primary-custom">Leave a Review</a>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No rental visits booked.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
