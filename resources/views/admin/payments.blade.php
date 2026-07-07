<x-admin-layout>
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="bi bi-cash-stack me-2 text-primary-custom"></i>Payment Management
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Payment ID</th>
                        <th>Payer</th>
                        <th>Payment Scheme</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $pay)
                        <tr>
                            <td>#{{ $pay->Payment_ID }}</td>
                            <td class="fw-semibold">
                                {{ $pay->user->Full_Name ?? 'N/A' }}
                                <div class="small text-muted">{{ $pay->user->Email ?? '' }}</div>
                            </td>
                            <td>
                                @if($pay->scheme)
                                    <strong>{{ $pay->scheme->Scheme_Name }}</strong>
                                    @if($pay->scheme->property)
                                        <div class="small text-muted">Property: {{ $pay->scheme->property->Title }}</div>
                                    @endif
                                @else
                                    <span class="text-muted">No Scheme</span>
                                @endif
                            </td>
                            <td class="fw-bold text-success">Rs. {{ number_format($pay->Amount, 2) }}</td>
                            <td>{{ $pay->Payment_Date ? \Carbon\Carbon::parse($pay->Payment_Date)->format('M d, Y') : 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $pay->Payment_Method }}</span></td>
                            <td>
                                <form action="{{ route('admin.payments.status', $pay->Payment_ID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="Payment_Status" class="form-select form-select-sm fw-semibold text-uppercase" style="width: auto; font-size: 0.85rem;" onchange="this.form.submit()">
                                        <option value="Pending" {{ $pay->Payment_Status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $pay->Payment_Status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Failed" {{ $pay->Payment_Status === 'Failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No payments logged in the system.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
