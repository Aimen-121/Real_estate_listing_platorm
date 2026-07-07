<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-card-list me-2 text-primary-custom"></i>Listing Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Listing ID</th>
                        <th>Property Title</th>
                        <th>Created By</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Views</th>
                        <th>Listing Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $lst)
                        <tr>
                            <td>#{{ $lst->Listing_ID }}</td>
                            <td class="fw-semibold">{{ $lst->property->Title ?? 'N/A' }}</td>
                            <td>{{ $lst->creator->Full_Name ?? 'N/A' }} <div class="small text-muted">{{ $lst->creator->Email ?? '' }}</div></td>
                            <td><span class="badge bg-secondary-custom text-primary-custom">{{ $lst->Listing_Type }}</span></td>
                            <td>Rs. {{ number_format($lst->Price, 2) }}</td>
                            <td><i class="bi bi-eye me-1"></i> {{ $lst->Total_Views ?? 0 }}</td>
                            <td>{{ $lst->Listing_Date ? \Carbon\Carbon::parse($lst->Listing_Date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $lst->Status === 'Active' ? 'bg-success' : 'bg-warning' }} rounded-pill px-2.5 py-1">
                                    {{ $lst->Status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Toggle Active/Inactive -->
                                    <form action="{{ route('admin.listings.toggle', $lst->Listing_ID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $lst->Status === 'Active' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                            {{ $lst->Status === 'Active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.listings.destroy', $lst->Listing_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Listing">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No listings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
