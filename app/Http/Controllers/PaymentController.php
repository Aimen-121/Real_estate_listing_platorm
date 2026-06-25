<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentScheme;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['scheme.property', 'user'])
            ->where('User_ID', auth()->id())
            ->orderBy('Payment_ID', 'desc')
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Scheme_ID'      => 'required|integer|exists:payment_scheme,Scheme_ID',
            'Amount'         => 'required|numeric|min:1',
            'Payment_Method' => 'required|string|max:50',
        ]);

        Payment::create([
            'User_ID'        => auth()->id(),
            'Scheme_ID'      => $validated['Scheme_ID'],
            'Amount'         => $validated['Amount'],
            'Payment_Date'   => now()->toDateString(),
            'Payment_Method' => $validated['Payment_Method'],
            'Payment_Status' => 'Pending',
        ]);

        return back()->with('success', 'Payment application submitted!');
    }
}
