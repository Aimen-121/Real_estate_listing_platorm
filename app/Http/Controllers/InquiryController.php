<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|integer|exists:listing,Listing_ID',
            'message'    => 'required|string|max:1000',
        ]);

        Inquiry::create([
            'User_ID'        => auth()->id(),
            'Listing_ID'     => $request->listing_id,
            'Message'        => $request->message,
            'Inquiry_Date'   => now()->toDateString(),
            'Inquiry_Status' => 'Open',
        ]);

        return back()->with('success', 'Your inquiry has been sent!');
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['user', 'listing.property.owner.user', 'listing.property.agent.user']);
        $this->authorizeInquiry($inquiry);
        return view('inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $this->authorizeInquiry($inquiry);
        $request->validate(['status' => 'required|in:Open,Pending,Closed']);
        $inquiry->update(['Inquiry_Status' => $request->status]);
        return back()->with('success', 'Inquiry status updated.');
    }

    private function authorizeInquiry(Inquiry $inquiry): void
    {
        $user = auth()->user();
        $isOwner = $inquiry->listing?->property?->Owner_ID === $user->User_ID;
        $isAgent = $inquiry->listing?->property?->Agent_ID === $user->User_ID;

        if ($inquiry->User_ID !== $user->User_ID && !$isOwner && !$isAgent && !$user->isAdmin()) {
            abort(403);
        }
    }
}
