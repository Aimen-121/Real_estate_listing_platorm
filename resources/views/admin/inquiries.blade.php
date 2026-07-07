<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-chat-left-text me-2 text-primary-custom"></i>Inquiry Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Inquiry ID</th>
                        <th>User</th>
                        <th>Property / Listing</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inq)
                        <tr>
                            <td>#{{ $inq->Inquiry_ID }}</td>
                            <td class="fw-semibold">
                                {{ $inq->user->Full_Name ?? 'N/A' }}
                                <div class="small text-muted">{{ $inq->user->Email ?? '' }}</div>
                            </td>
                            <td>
                                @if($inq->listing && $inq->listing->property)
                                    <a href="{{ route('listings.show', $inq->listing->Listing_ID) }}" target="_blank" class="text-decoration-none text-dark fw-medium">
                                        {{ $inq->listing->property->Title }}
                                    </a>
                                    <div class="small text-muted">ID: #{{ $inq->listing->Listing_ID }} ({{ $inq->listing->Listing_Type }})</div>
                                @else
                                    <span class="text-muted">Deleted Listing</span>
                                @endif
                            </td>
                            <td>
                                <div class="bg-light p-2 rounded text-dark small" style="max-width: 250px; white-space: normal;">
                                    {{ $inq->Message }}
                                </div>
                            </td>
                            <td>{{ $inq->Inquiry_Date ? \Carbon\Carbon::parse($inq->Inquiry_Date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.inquiries.status', $inq->Inquiry_ID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="Inquiry_Status" class="form-select form-select-sm fw-semibold" style="width: auto; font-size: 0.85rem;" onchange="this.form.submit()">
                                        <option value="Open" {{ $inq->Inquiry_Status === 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="Resolved" {{ $inq->Inquiry_Status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="Closed" {{ $inq->Inquiry_Status === 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.inquiries.destroy', $inq->Inquiry_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Inquiry">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
