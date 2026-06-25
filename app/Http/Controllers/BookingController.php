<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|integer|exists:property,Property_ID',
            'visit_date'  => 'required|date|after_or_equal:today',
            'visit_time'  => 'required',
        ]);

        $property = Property::findOrFail($request->property_id);

        Booking::create([
            'User_ID'        => auth()->id(),
            'Property_ID'    => $property->Property_ID,
            'Owner_ID'       => $property->Owner_ID,
            'Agent_ID'       => $property->Agent_ID,
            'Visit_Date'     => $request->visit_date,
            'Visit_Time'     => $request->visit_time,
            'Booking_Status' => 'Pending',
        ]);

        return back()->with('success', 'Visit booked! The owner will confirm shortly.');
    }

    public function confirm(Booking $booking)
    {
        $this->authorizeOwnerOrAgent($booking);
        $booking->update(['Booking_Status' => 'Confirmed']);
        return back()->with('success', 'Booking confirmed.');
    }

    public function cancel(Booking $booking)
    {
        $user = auth()->user();
        if ($booking->User_ID !== $user->User_ID && $booking->Owner_ID !== $user->User_ID && !$user->isAdmin()) {
            abort(403);
        }
        $booking->update(['Booking_Status' => 'Cancelled']);
        return back()->with('success', 'Booking cancelled.');
    }

    public function complete(Booking $booking)
    {
        $this->authorizeOwnerOrAgent($booking);
        $booking->update(['Booking_Status' => 'Completed']);
        return back()->with('success', 'Booking marked as completed.');
    }

    private function authorizeOwnerOrAgent(Booking $booking): void
    {
        $user = auth()->user();
        if ($booking->Owner_ID !== $user->User_ID && $booking->Agent_ID !== $user->User_ID && !$user->isAdmin()) {
            abort(403);
        }
    }
}
