<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Listing;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Favorite;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dynamic multi-role dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        // Load the roles relations to check flags
        $user->load(['admin', 'owner', 'agent', 'buyer', 'renter']);

        $data = [];

        // 1. Admin Analytics and Moderation Data
        if ($user->isAdmin()) {
            $data['admin'] = [
                'total_users' => User::count(),
                'total_properties' => Property::count(),
                'total_listings' => Listing::count(),
                'total_bookings' => Booking::count(),
                'total_inquiries' => Inquiry::count(),
                'total_reviews' => Review::count(),
                'total_revenue' => Payment::where('Payment_Status', 'Completed')->sum('Amount'),
                'recent_users' => User::orderBy('User_ID', 'desc')->limit(5)->get(),
                'recent_payments' => Payment::with(['user', 'scheme.property'])->orderBy('Payment_ID', 'desc')->limit(5)->get(),
            ];
        }

        // 2. Owner Management Data
        if ($user->isOwner()) {
            $owner_id = $user->User_ID;
            $properties = Property::where('Owner_ID', $owner_id)->get();
            $property_ids = $properties->pluck('Property_ID')->toArray();
            
            $listings = Listing::whereIn('Property_ID', $property_ids)->get();
            $listing_ids = $listings->pluck('Listing_ID')->toArray();

            $data['owner'] = [
                'properties' => $properties,
                'listings' => $listings,
                'inquiries' => Inquiry::with(['user', 'listing.property'])
                    ->whereIn('Listing_ID', $listing_ids)
                    ->orderBy('Inquiry_ID', 'desc')->get(),
                'bookings' => Booking::with(['user', 'property', 'agent.user'])
                    ->where('Owner_ID', $owner_id)
                    ->orderBy('Booking_ID', 'desc')->get(),
                'reviews' => Review::with(['user', 'property'])
                    ->whereIn('Property_ID', $property_ids)
                    ->orderBy('Review_ID', 'desc')->get(),
                'payments' => Payment::with(['user', 'scheme.property'])
                    ->whereIn('Scheme_ID', function($query) use ($property_ids) {
                        $query->select('Scheme_ID')->from('payment_scheme')->whereIn('Property_ID', $property_ids);
                    })->orderBy('Payment_ID', 'desc')->get(),
            ];
        }

        // 3. Agent Operations Data
        if ($user->isAgent()) {
            $agent_id = $user->User_ID;
            $properties = Property::where('Agent_ID', $agent_id)->get();
            $property_ids = $properties->pluck('Property_ID')->toArray();
            
            $listings = Listing::whereIn('Property_ID', $property_ids)->get();
            $listing_ids = $listings->pluck('Listing_ID')->toArray();

            $data['agent'] = [
                'properties' => $properties,
                'listings' => $listings,
                'inquiries' => Inquiry::with(['user', 'listing.property'])
                    ->whereIn('Listing_ID', $listing_ids)
                    ->orderBy('Inquiry_ID', 'desc')->get(),
                'bookings' => Booking::with(['user', 'property', 'owner.user'])
                    ->where('Agent_ID', $agent_id)
                    ->orderBy('Booking_ID', 'desc')->get(),
                'reviews' => Review::with(['user', 'property'])
                    ->where('Agent_ID', $agent_id)
                    ->orderBy('Review_ID', 'desc')->get(),
            ];
        }

        // 4. Buyer Personal Dashboard Data
        if ($user->isBuyer()) {
            $buyer_id = $user->User_ID;
            $data['buyer'] = [
                'favorites' => Favorite::with(['listing.property.images', 'listing.creator'])
                    ->where('User_ID', $buyer_id)->get(),
                'inquiries' => Inquiry::with(['listing.property'])
                    ->where('User_ID', $buyer_id)
                    ->orderBy('Inquiry_ID', 'desc')->get(),
                'bookings' => Booking::with(['property', 'owner.user', 'agent.user'])
                    ->where('User_ID', $buyer_id)
                    ->orderBy('Booking_ID', 'desc')->get(),
                'payments' => Payment::with(['scheme.property'])
                    ->where('User_ID', $buyer_id)
                    ->orderBy('Payment_ID', 'desc')->get(),
                'reviews' => Review::with(['property', 'agent.user'])
                    ->where('User_ID', $buyer_id)
                    ->orderBy('Review_ID', 'desc')->get(),
            ];
        }

        // 5. Renter Personal Dashboard Data
        if ($user->isRenter()) {
            $renter_id = $user->User_ID;
            $data['renter'] = [
                'favorites' => Favorite::with(['listing.property.images', 'listing.creator'])
                    ->where('User_ID', $renter_id)->get(),
                'bookings' => Booking::with(['property', 'owner.user', 'agent.user'])
                    ->where('User_ID', $renter_id)
                    ->orderBy('Booking_ID', 'desc')->get(),
                'payments' => Payment::with(['scheme.property'])
                    ->where('User_ID', $renter_id)
                    ->orderBy('Payment_ID', 'desc')->get(),
                'reviews' => Review::with(['property', 'agent.user'])
                    ->where('User_ID', $renter_id)
                    ->orderBy('Review_ID', 'desc')->get(),
            ];
        }

        return view('dashboard', compact('user', 'data'));
    }
}
