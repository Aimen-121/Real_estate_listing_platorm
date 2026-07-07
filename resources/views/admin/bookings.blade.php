<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar-check me-2 text-primary-custom"></i>Booking Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Client / Buyer</th>
                        <th>Property</th>
                        <th>Owner</th>
                        <th>Assigned Agent</th>
                        <th>Scheduled Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $book)
                        <tr>
                            <td>#{{ $book->Booking_ID }}</td>
                            <td class="fw-semibold">
                                {{ $book->user->Full_Name ?? 'N/A' }}
                                <div class="small text-muted">{{ $book->user->Email ?? '' }}</div>
                            </td>
                            <td>
                                @if($book->property)
                                    <a href="{{ route('properties.show', $book->property->Property_ID) }}" target="_blank" class="text-decoration-none text-dark fw-medium">
                                        {{ $book->property->Title }}
                                    </a>
                                    <div class="small text-muted">{{ $book->property->City }}</div>
                                @else
                                    <span class="text-muted">Deleted Property</span>
                                @endif
                            </td>
                            <td>{{ $book->owner->user->Full_Name ?? 'N/A' }}</td>
                            <td>{{ $book->agent->user->Full_Name ?? 'No Agent Assigned' }}</td>
                            <td>{{ $book->Visit_Date ? \Carbon\Carbon::parse($book->Visit_Date)->format('M d, Y') : 'N/A' }}</td>
                            <td>{{ $book->Visit_Time ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.bookings.status', $book->Booking_ID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="Booking_Status" class="form-select form-select-sm fw-semibold" style="width: auto; font-size: 0.85rem;" onchange="this.form.submit()">
                                        <option value="Pending" {{ $book->Booking_Status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Confirmed" {{ $book->Booking_Status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="Cancelled" {{ $book->Booking_Status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="Completed" {{ $book->Booking_Status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.bookings.destroy', $book->Booking_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Booking">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
