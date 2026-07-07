<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-people-fill me-2 text-primary-custom"></i>User Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Identity Info</th>
                        <th>Assigned Roles</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>#{{ $u->User_ID }}</td>
                            <td class="fw-semibold">{{ $u->Full_Name }}</td>
                            <td>{{ $u->Email }}</td>
                            <td>{{ $u->Phone_Number ?? 'N/A' }}</td>
                            <td>
                                @if($u->Identity_Type)
                                    <span class="small text-muted">{{ $u->Identity_Type }}:</span> <strong class="small">{{ $u->Identity_Number }}</strong>
                                @else
                                    <span class="text-muted small">None</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($u->getRoles() as $role)
                                        <span class="badge bg-secondary-custom text-primary-custom rounded-pill py-1 px-2 fw-semibold" style="font-size: 0.7rem;">
                                            {{ $role }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $u->Status === 'Active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} rounded-pill px-2.5 py-1 fw-semibold">
                                    {{ $u->Status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Toggle Status -->
                                    <form action="{{ route('admin.users.toggle', $u->User_ID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Toggle Status">
                                            <i class="bi bi-arrow-repeat me-1"></i>Toggle
                                        </button>
                                    </form>
                                    
                                    <!-- Delete User (Exclude oneself) -->
                                    @if($u->User_ID !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->User_ID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This will delete all associated data (properties, bookings, listings) via cascades.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No users found in the system.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
