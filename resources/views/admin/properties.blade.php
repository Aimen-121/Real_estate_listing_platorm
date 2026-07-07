<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-building me-2 text-primary-custom"></i>Property Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Property Title</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Type / Category</th>
                        <th>Price</th>
                        <th>Agent Assignment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $prop)
                        <tr>
                            <td>#{{ $prop->Property_ID }}</td>
                            <td class="fw-semibold">
                                <a href="{{ route('properties.show', $prop->Property_ID) }}" target="_blank" class="text-decoration-none text-dark">
                                    {{ $prop->Title }}
                                </a>
                            </td>
                            <td>{{ $prop->owner->user->Full_Name ?? 'N/A' }}</td>
                            <td>{{ $prop->City }}, {{ $prop->State }}</td>
                            <td>
                                <span class="badge bg-secondary-custom text-primary-custom">{{ $prop->Property_Type }}</span>
                                <div class="small text-muted">{{ $prop->category->Category_Name ?? 'No Category' }}</div>
                            </td>
                            <td>Rs. {{ number_format($prop->Price, 2) }}</td>
                            <td>
                                <form action="{{ route('admin.properties.assign-agent', $prop->Property_ID) }}" method="POST" class="d-flex align-items-center gap-1">
                                    @csrf
                                    <select name="Agent_ID" class="form-select form-select-sm" style="min-width: 140px; font-size: 0.85rem;">
                                        <option value="">No Agent</option>
                                        @foreach($agents as $agt)
                                            <option value="{{ $agt->User_ID }}" {{ $prop->Agent_ID == $agt->User_ID ? 'selected' : '' }}>
                                                {{ $agt->user->Full_Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary-custom px-2" title="Save Assignment">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="badge {{ $prop->Availability_Status === 'Available' ? 'bg-success' : 'bg-warning' }} rounded-pill px-2.5 py-1">
                                    {{ $prop->Availability_Status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('properties.show', $prop->Property_ID) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Property"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('properties.edit', $prop->Property_ID) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Edit Property"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.properties.destroy', $prop->Property_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Property"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
