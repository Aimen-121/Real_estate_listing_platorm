<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer|exists:property,Property_ID',
            'booking_id'  => 'required|integer|exists:booking,Booking_ID',
        ]);

        $property = Property::with('agent.user')->findOrFail($request->property_id);
        $booking  = Booking::findOrFail($request->booking_id);

        // Only the user who booked may leave a review
        if ($booking->User_ID !== auth()->id()) {
            abort(403);
        }

        return view('reviews.create', compact('property', 'booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Property_ID' => 'required|integer|exists:property,Property_ID',
            'Booking_ID'  => 'required|integer|exists:booking,Booking_ID',
            'Agent_ID'    => 'nullable|integer|exists:agent,User_ID',
            'Rating'      => 'required|integer|min:1|max:5',
            'Comment'     => 'required|string|max:1000',
        ]);

        // Prevent duplicate reviews
        $exists = Review::where('User_ID', auth()->id())
            ->where('Property_ID', $validated['Property_ID'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already submitted a review for this property.');
        }

        Review::create([
            'User_ID'     => auth()->id(),
            'Booking_ID'  => $validated['Booking_ID'],
            'Property_ID' => $validated['Property_ID'],
            'Agent_ID'    => $validated['Agent_ID'] ?? null,
            'Rating'      => $validated['Rating'],
            'Comment'     => $validated['Comment'],
            'Review_Date' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Review submitted! Thank you.');
    }
}
