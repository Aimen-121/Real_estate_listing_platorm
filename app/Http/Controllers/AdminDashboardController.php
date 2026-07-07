<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Listing;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard Home with statistics.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_properties' => Property::count(),
            'total_listings' => Listing::count(),
            'total_categories' => PropertyCategory::count(),
            'total_amenities' => Amenity::count(),
            'total_bookings' => Booking::count(),
            'total_inquiries' => Inquiry::count(),
            'total_reviews' => Review::count(),
            'total_payments' => Payment::count(),
            'total_revenue' => Payment::where('Payment_Status', 'Completed')->sum('Amount'),
        ];

        $recent_users = User::orderBy('User_ID', 'desc')->limit(5)->get();
        $recent_payments = Payment::with(['user', 'scheme.property'])->orderBy('Payment_ID', 'desc')->limit(5)->get();
        $recent_listings = Listing::with('property')->orderBy('Listing_ID', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_payments', 'recent_listings'));
    }

    /**
     * User Management.
     */
    public function users(): View
    {
        $users = User::with(['admin', 'owner', 'agent', 'buyer', 'renter'])->get();

        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        $user->Status = $user->Status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->User_ID === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User account deleted successfully.');
    }

    /**
     * Property Management.
     */
    public function properties(): View
    {
        $properties = Property::with(['owner.user', 'agent.user', 'category'])->get();
        $agents = Agent::with('user')->get();

        return view('admin.properties', compact('properties', 'agents'));
    }

    public function assignAgent(Request $request, Property $property): RedirectResponse
    {
        $request->validate([
            'Agent_ID' => ['nullable', 'integer', 'exists:agent,User_ID'],
        ]);

        $property->Agent_ID = $request->Agent_ID;
        $property->save();

        return back()->with('success', 'Property agent assignment updated.');
    }

    public function deleteProperty(Property $property): RedirectResponse
    {
        $property->delete();

        return back()->with('success', 'Property deleted successfully.');
    }

    /**
     * Listing Management.
     */
    public function listings(): View
    {
        $listings = Listing::with(['property', 'creator'])->get();

        return view('admin.listings', compact('listings'));
    }

    public function toggleListingStatus(Listing $listing): RedirectResponse
    {
        $listing->Status = $listing->Status === 'Active' ? 'Inactive' : 'Active';
        $listing->save();

        return back()->with('success', 'Listing status updated successfully.');
    }

    public function deleteListing(Listing $listing): RedirectResponse
    {
        $listing->delete();

        return back()->with('success', 'Listing deleted successfully.');
    }

    /**
     * Category Management.
     */
    public function categories(): View
    {
        $categories = PropertyCategory::all();

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'Category_Name' => ['required', 'string', 'max:100'],
            'Category_Type' => ['required', 'string', 'max:50'],
        ]);

        PropertyCategory::create([
            'Category_Name' => $request->Category_Name,
            'Category_Type' => $request->Category_Type,
        ]);

        return back()->with('success', 'Property category created successfully.');
    }

    public function updateCategory(Request $request, PropertyCategory $category): RedirectResponse
    {
        $request->validate([
            'Category_Name' => ['required', 'string', 'max:100'],
            'Category_Type' => ['required', 'string', 'max:50'],
        ]);

        $category->update([
            'Category_Name' => $request->Category_Name,
            'Category_Type' => $request->Category_Type,
        ]);

        return back()->with('success', 'Property category updated successfully.');
    }

    public function deleteCategory(PropertyCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Property category deleted successfully.');
    }

    /**
     * Amenity Management.
     */
    public function amenities(): View
    {
        $amenities = Amenity::all();

        return view('admin.amenities', compact('amenities'));
    }

    public function storeAmenity(Request $request): RedirectResponse
    {
        $request->validate([
            'Amenity_Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string', 'max:255'],
        ]);

        Amenity::create([
            'Amenity_Name' => $request->Amenity_Name,
            'Description' => $request->Description,
        ]);

        return back()->with('success', 'Amenity created successfully.');
    }

    public function updateAmenity(Request $request, Amenity $amenity): RedirectResponse
    {
        $request->validate([
            'Amenity_Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string', 'max:255'],
        ]);

        $amenity->update([
            'Amenity_Name' => $request->Amenity_Name,
            'Description' => $request->Description,
        ]);

        return back()->with('success', 'Amenity updated successfully.');
    }

    public function deleteAmenity(Amenity $amenity): RedirectResponse
    {
        $amenity->delete();

        return back()->with('success', 'Amenity deleted successfully.');
    }

    /**
     * Booking Management.
     */
    public function bookings(): View
    {
        $bookings = Booking::with(['user', 'property', 'owner.user', 'agent.user'])->get();

        return view('admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'Booking_Status' => ['required', 'string', 'in:Pending,Confirmed,Cancelled,Completed'],
        ]);

        $booking->Booking_Status = $request->Booking_Status;
        $booking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function deleteBooking(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }

    /**
     * Inquiry Management.
     */
    public function inquiries(): View
    {
        $inquiries = Inquiry::with(['user', 'listing.property'])->get();

        return view('admin.inquiries', compact('inquiries'));
    }

    public function updateInquiryStatus(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $request->validate([
            'Inquiry_Status' => ['required', 'string', 'in:Open,Resolved,Closed'],
        ]);

        $inquiry->Inquiry_Status = $request->Inquiry_Status;
        $inquiry->save();

        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function deleteInquiry(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted successfully.');
    }

    /**
     * Review Moderation.
     */
    public function reviews(): View
    {
        $reviews = Review::with(['user', 'property', 'agent.user'])->get();

        return view('admin.reviews', compact('reviews'));
    }

    public function deleteReview(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review moderated and deleted successfully.');
    }

    /**
     * Payment Management.
     */
    public function payments(): View
    {
        $payments = Payment::with(['user', 'scheme.property'])->get();

        return view('admin.payments', compact('payments'));
    }

    public function updatePaymentStatus(Request $request, Payment $payment): RedirectResponse
    {
        $request->validate([
            'Payment_Status' => ['required', 'string', 'in:Completed,Pending,Failed'],
        ]);

        $payment->Payment_Status = $request->Payment_Status;
        $payment->save();

        return back()->with('success', 'Payment status updated successfully.');
    }
}
