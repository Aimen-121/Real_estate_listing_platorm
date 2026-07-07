<x-admin-layout>
    @php
        $editCategory = null;
        if (request('edit_id')) {
            $editCategory = $categories->firstWhere('Category_ID', request('edit_id'));
        }
    @endphp

    <div class="row g-4">
        <!-- Categories Table (Left) -->
        <div class="col-md-7">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <h5 class="fw-bold mb-3 text-dark">
                    <i class="bi bi-tags-fill me-2 text-primary-custom"></i>Property Categories
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td>#{{ $cat->Category_ID }}</td>
                                    <td class="fw-semibold">{{ $cat->Category_Name }}</td>
                                    <td>{{ $cat->Category_Type }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="?edit_id={{ $cat->Category_ID }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $cat->Category_ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                                    <td colspan="4" class="text-center py-4 text-muted">No categories defined yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add/Edit Category Form (Right) -->
        <div class="col-md-5">
            <div class="card card-custom p-4 border-0 shadow-sm">
                @if($editCategory)
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-pencil-square me-2 text-primary-custom"></i>Edit Category</h5>
                    <form action="{{ route('admin.categories.update', $editCategory->Category_ID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="Category_Name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="Category_Name" id="Category_Name" class="form-control" value="{{ old('Category_Name', $editCategory->Category_Name) }}" required placeholder="e.g. Residential, Commercial">
                        </div>

                        <div class="mb-3">
                            <label for="Category_Type" class="form-label fw-semibold">Category Type</label>
                            <input type="text" name="Category_Type" id="Category_Type" class="form-control" value="{{ old('Category_Type', $editCategory->Category_Type) }}" required placeholder="e.g. Apartment, Office, Shop">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom flex-grow-1 fw-semibold">Update Category</button>
                            <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary fw-semibold">Cancel</a>
                        </div>
                    </form>
                @else
                    <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary-custom"></i>Add Category</h5>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="Category_Name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="Category_Name" id="Category_Name" class="form-control" value="{{ old('Category_Name') }}" required placeholder="e.g. Residential, Commercial">
                        </div>

                        <div class="mb-3">
                            <label for="Category_Type" class="form-label fw-semibold">Category Type</label>
                            <input type="text" name="Category_Type" id="Category_Type" class="form-control" value="{{ old('Category_Type') }}" required placeholder="e.g. Apartment, Office, Shop">
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 fw-semibold">Create Category</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
