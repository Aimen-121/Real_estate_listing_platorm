<x-admin-layout>
    <!-- Metric Statistics Grid -->
    <div class="row g-3 mb-4">
        <!-- Total Users -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Users</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-people fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Total Properties -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Properties</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_properties'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-building fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Total Listings -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Listings</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_listings'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-card-list fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Revenue</h6>
                        <h3 class="fw-bold mb-0 text-dark">Rs. {{ number_format($stats['total_revenue']) }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-cash-stack fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Bookings</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_bookings'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-calendar-check fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Inquiries -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Inquiries</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_inquiries'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-chat-left-text fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Reviews</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_reviews'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-chat-square-quote fs-4"></i></div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase small fw-bold">Categories</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_categories'] }}</h3>
                    </div>
                    <div class="bg-light p-3 rounded-3 text-primary-custom d-none d-sm-block"><i class="bi bi-tags fs-4"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Logs Row -->
    <div class="row g-4 mb-4">
        <!-- Recent Users -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <h5 class="fw-bold mb-3"><i class="bi bi-person-plus-fill me-2 text-primary-custom"></i>Recent Users</h5>
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
                            @forelse($recent_users as $u)
                                <tr>
                                    <td class="fw-semibold">{{ $u->Full_Name }}</td>
                                    <td>{{ $u->Email }}</td>
                                    <td>
                                        <span class="badge {{ $u->Status === 'Active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-2.5 py-1 text-xs">
                                            {{ $u->Status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-md-6">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary-custom"></i>Recent Payments</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_payments as $p)
                                <tr>
                                    <td class="fw-semibold">{{ $p->user->Full_Name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($p->Amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $p->Payment_Status === 'Completed' ? 'bg-success' : ($p->Payment_Status === 'Pending' ? 'bg-warning' : 'bg-danger') }} rounded-pill px-2.5 py-1">
                                            {{ $p->Payment_Status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Listings -->
    <div class="card card-custom p-4 border-0 shadow-sm mb-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-card-list me-2 text-primary-custom"></i>Recent Listings</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Listing ID</th>
                        <th>Property Title</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_listings as $lst)
                        <tr>
                            <td>#{{ $lst->Listing_ID }}</td>
                            <td class="fw-semibold">{{ $lst->property->Title ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary-custom text-primary-custom">{{ $lst->Listing_Type }}</span></td>
                            <td>Rs. {{ number_format($lst->Price, 2) }}</td>
                            <td>
                                <span class="badge {{ $lst->Status === 'Active' ? 'bg-success' : 'bg-warning' }} rounded-pill px-2.5 py-1">
                                    {{ $lst->Status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No listings created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
