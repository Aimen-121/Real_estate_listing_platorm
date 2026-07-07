<div class="card card-custom border-0 shadow-sm p-3 sidebar-custom">
    <h6 class="text-uppercase text-muted fw-bold px-3 mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Management Panels</h6>
    <div class="nav flex-column">
        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>Dashboard Home
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="bi bi-people"></i>User Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.properties') ? 'active' : '' }}" href="{{ route('admin.properties') }}">
            <i class="bi bi-building"></i>Property Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.listings') ? 'active' : '' }}" href="{{ route('admin.listings') }}">
            <i class="bi bi-card-list"></i>Listing Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}" href="{{ route('admin.categories') }}">
            <i class="bi bi-tags"></i>Category Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.amenities') ? 'active' : '' }}" href="{{ route('admin.amenities') }}">
            <i class="bi bi-stars"></i>Amenity Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
            <i class="bi bi-calendar-check"></i>Booking Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.inquiries') ? 'active' : '' }}" href="{{ route('admin.inquiries') }}">
            <i class="bi bi-chat-left-text"></i>Inquiry Management
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.reviews') ? 'active' : '' }}" href="{{ route('admin.reviews') }}">
            <i class="bi bi-chat-square-quote"></i>Review Moderation
        </a>
        <a class="sidebar-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}" href="{{ route('admin.payments') }}">
            <i class="bi bi-cash-stack"></i>Payment Management
        </a>
    </div>
</div>
