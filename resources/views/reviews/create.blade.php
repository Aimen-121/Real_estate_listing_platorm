<x-app-layout>
    <div class="container py-5" style="max-width:640px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
            <h3 class="fw-bold mb-0">Leave a Review</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card card-custom p-4">
            <!-- Property Info -->
            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#F8FAFC;border:1px solid #e2e8f0;">
                <i class="bi bi-house-check fs-2 text-primary-custom"></i>
                <div>
                    <div class="fw-bold">{{ $property->Title }}</div>
                    <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $property->Location }}, {{ $property->City }}</div>
                </div>
            </div>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="Property_ID" value="{{ $property->Property_ID }}">
                <input type="hidden" name="Booking_ID" value="{{ $booking->Booking_ID }}">
                @if($property->Agent_ID)
                    <input type="hidden" name="Agent_ID" value="{{ $property->Agent_ID }}">
                @endif

                <div class="mb-4">
                    <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                    <div class="d-flex gap-2 fs-3" id="starRating">
                        @for($i=1;$i<=5;$i++)
                            <label class="cursor-pointer text-muted" style="cursor:pointer;" data-value="{{ $i }}">
                                <i class="bi bi-star" id="star{{ $i }}"></i>
                            </label>
                        @endfor
                    </div>
                    <input type="hidden" name="Rating" id="ratingInput" value="{{ old('Rating') }}" required>
                    <div class="form-text">Click to rate your experience.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Comment <span class="text-danger">*</span></label>
                    <textarea name="Comment" class="form-control" rows="5" placeholder="Share your experience with this property…" required>{{ old('Comment') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2">
                    <i class="bi bi-send me-2"></i>Submit Review
                </button>
            </form>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('#starRating label');
        const input = document.getElementById('ratingInput');
        stars.forEach((star, idx) => {
            star.addEventListener('click', () => {
                input.value = idx + 1;
                stars.forEach((s, i) => {
                    const icon = s.querySelector('i');
                    icon.className = i <= idx ? 'bi bi-star-fill text-warning' : 'bi bi-star text-muted';
                });
            });
            star.addEventListener('mouseover', () => {
                stars.forEach((s, i) => {
                    const icon = s.querySelector('i');
                    icon.className = i <= idx ? 'bi bi-star-fill text-warning' : 'bi bi-star text-muted';
                });
            });
            star.addEventListener('mouseout', () => {
                const val = parseInt(input.value) || 0;
                stars.forEach((s, i) => {
                    const icon = s.querySelector('i');
                    icon.className = i < val ? 'bi bi-star-fill text-warning' : 'bi bi-star text-muted';
                });
            });
        });
    </script>
</x-app-layout>
