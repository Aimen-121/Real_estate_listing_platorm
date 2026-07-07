<x-admin-layout>
    @php
        $editAmenity = null;
        if (request('edit_id')) {
            $editAmenity = $amenities->firstWhere('Amenity_ID', request('edit_id'));
        }
    @endphp

    <div class="row g-4">
        <!-- Amenities Table (Left) -->
        <div class="col-md-7">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <h5 class="fw-bold mb-3 text-dark">
                    <i class="bi bi-stars me-2 text-primary-custom"></i>Property Amenities
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Amenity Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($amenities as $amn)
                                <tr>
                                    <td>#{{ $amn->Amenity_ID }}</td>
                                    <td class="fw-semibold">{{ $amn->Amenity_Name }}</td>
                                    <td class="text-muted small">{{ $amn->Description ?? 'No description' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="?edit_id={{ $amn->Amenity_ID }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.amenities.destroy', $amn->Amenity_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this amenity?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No amenities defined yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add/Edit Amenity Form (Right) -->
        <div class="col-md-5">
            <div class="card card-custom p-4 border-0 shadow-sm">
                @if($editAmenity)
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-pencil-square me-2 text-primary-custom"></i>Edit Amenity</h5>
                    <form action="{{ route('admin.amenities.update', $editAmenity->Amenity_ID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="Amenity_Name" class="form-label fw-semibold">Amenity Name</label>
                            <input type="text" name="Amenity_Name" id="Amenity_Name" class="form-control" value="{{ old('Amenity_Name', $editAmenity->Amenity_Name) }}" required placeholder="e.g. Swimming Pool, Gymnasium">
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label fw-semibold">Description</label>
                            <textarea name="Description" id="Description" class="form-control" rows="3" placeholder="Brief description of the amenity">{{ old('Description', $editAmenity->Description) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom flex-grow-1 fw-semibold">Update Amenity</button>
                            <a href="{{ route('admin.amenities') }}" class="btn btn-outline-secondary fw-semibold">Cancel</a>
                        </div>
                    </form>
                @else
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary-custom"></i>Add Amenity</h5>
                    <form action="{{ route('admin.amenities.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="Amenity_Name" class="form-label fw-semibold">Amenity Name</label>
                            <input type="text" name="Amenity_Name" id="Amenity_Name" class="form-control" value="{{ old('Amenity_Name') }}" required placeholder="e.g. Swimming Pool, Gymnasium">
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label fw-semibold">Description</label>
                            <textarea name="Description" id="Description" class="form-control" rows="3" placeholder="Brief description of the amenity">{{ old('Description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 fw-semibold">Create Amenity</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
