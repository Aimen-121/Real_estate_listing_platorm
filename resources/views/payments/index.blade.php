<x-app-layout>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0"><i class="bi bi-wallet2 me-2 text-primary-custom"></i>My Payments</h3>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($payments->isEmpty())
            <div class="text-center py-5 card card-custom">
                <i class="bi bi-receipt fs-1 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">No payment records yet</h5>
                <p class="text-muted">When you apply for a payment scheme, it will appear here.</p>
                <a href="{{ route('properties.search') }}" class="btn btn-primary-custom mt-2">Browse Properties</a>
            </div>
        @else
            <div class="table-responsive card card-custom p-0 overflow-hidden">
                <table class="table mb-0 align-middle">
                    <thead style="background:var(--secondary-color);">
                        <tr>
                            <th class="px-4 py-3 text-muted small text-uppercase fw-bold">#</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Property / Scheme</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Amount</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Method</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Date</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr class="border-top">
                            <td class="px-4 py-3 text-muted small">{{ $payment->Payment_ID }}</td>
                            <td class="py-3">
                                <div class="fw-semibold">{{ $payment->scheme->Scheme_Name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $payment->scheme->property->Title ?? '' }}</div>
                            </td>
                            <td class="py-3 fw-bold text-primary-custom">Rs. {{ number_format($payment->Amount, 0) }}</td>
                            <td class="py-3 text-muted small">{{ $payment->Payment_Method }}</td>
                            <td class="py-3 text-muted small">{{ $payment->Payment_Date }}</td>
                            <td class="py-3">
                                @php
                                    $sc = ['Pending'=>'bg-warning text-dark','Confirmed'=>'bg-success','Failed'=>'bg-danger'];
                                    $cls = $sc[$payment->Payment_Status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $cls }} rounded-pill">{{ $payment->Payment_Status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
