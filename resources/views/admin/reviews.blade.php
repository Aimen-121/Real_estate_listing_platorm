<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-chat-square-quote me-2 text-primary-custom"></i>Review Moderation
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Reviewer</th>
                        <th>Property</th>
                        <th>Agent Involved</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $rev)
                        <tr>
                            <td>#{{ $rev->Review_ID }}</td>
                            <td class="fw-semibold">
                                {{ $rev->user->Full_Name ?? 'N/A' }}
                                <div class="small text-muted">{{ $rev->user->Email ?? '' }}</div>
                            </td>
                            <td>{{ $rev->property->Title ?? 'Deleted Property' }}</td>
                            <td>{{ $rev->agent->user->Full_Name ?? 'No Agent Assigned' }}</td>
                            <td>
                                <div class="text-nowrap">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $rev->Rating ? 'text-warning' : 'text-secondary-custom' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark" style="max-width: 250px; white-space: normal;">
                                    "{{ $rev->Comment }}"
                                </div>
                            </td>
                            <td>{{ $rev->Review_Date ? \Carbon\Carbon::parse($rev->Review_Date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.destroy', $rev->Review_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete/moderate this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Moderate & Delete">
                                        <i class="bi bi-shield-x me-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No reviews left by buyers/renters yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
