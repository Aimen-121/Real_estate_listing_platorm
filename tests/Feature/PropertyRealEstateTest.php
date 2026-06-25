<?php

use App\Models\User;
use App\Models\Owner;
use App\Models\Buyer;
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\Listing;
use App\Models\Favorite;
use App\Models\Inquiry;
use App\Models\Booking;
use App\Models\PaymentScheme;
use App\Models\Payment;
use App\Models\Review;

test('full real estate platform workflow', function () {
    // 1. Create Owner & Buyer users
    $ownerUser = User::factory()->create();
    Owner::create([
        'User_ID' => $ownerUser->User_ID,
        'Ownership_Type' => 'Individual'
    ]);

    $buyerUser = User::factory()->create();
    Buyer::create([
        'User_ID' => $buyerUser->User_ID,
        'Preference' => 'House'
    ]);

    // 2. Create Property Category
    $category = PropertyCategory::create([
        'Category_Name' => 'Villa'
    ]);

    // 3. Create Property (as Owner)
    $property = Property::create([
        'Owner_ID' => $ownerUser->User_ID,
        'Category_ID' => $category->Category_ID,
        'Title' => 'Luxury Sea View Villa',
        'Description' => 'Beautiful villa with modern amenities.',
        'Location' => 'Clifton Block 5',
        'City' => 'Karachi',
        'State' => 'Sindh',
        'Zip_Code' => '75600',
        'Area_Size' => 500,
        'Bedrooms' => 4,
        'Bathrooms' => 5,
        'Property_Type' => 'Residential',
        'Price' => 15000000,
        'Availability_Status' => 'Available',
    ]);

    expect($property->Property_ID)->not->toBeNull();

    // 4. Create Payment Scheme
    $scheme = PaymentScheme::create([
        'Property_ID' => $property->Property_ID,
        'Advance_Percentage' => 20,
        'Installment_Months' => 24,
    ]);

    expect($scheme->Scheme_ID)->not->toBeNull();

    // 5. Create Listing (as Owner)
    $listing = Listing::create([
        'Property_ID' => $property->Property_ID,
        'Created_By' => $ownerUser->User_ID,
        'Listing_Type' => 'Sale',
        'Price' => 15000000,
        'Listing_Date' => now()->toDateString(),
        'Expire_Date' => now()->addMonths(6)->toDateString(),
        'Status' => 'Active',
        'Description' => 'Direct owner sale.',
        'Featured_Flag' => true,
        'Total_Views' => 0,
    ]);

    expect($listing->Listing_ID)->not->toBeNull();

    // 6. Test Property Search / Filter (as Public/Buyer)
    $response = $this->get(route('properties.search', [
        'city' => 'Karachi',
        'category_id' => $category->Category_ID,
        'type' => 'Residential',
        'min_price' => 10000000,
        'max_price' => 20000000,
    ]));
    $response->assertOk();
    $response->assertSee('Luxury Sea View Villa');

    // 7. Add to Favorites (as Buyer)
    $response = $this->actingAs($buyerUser)->post(route('favorites.store'), [
        'listing_id' => $listing->Listing_ID
    ]);
    $response->assertRedirect();
    expect(Favorite::where('User_ID', $buyerUser->User_ID)->where('Listing_ID', $listing->Listing_ID)->exists())->toBeTrue();

    // 8. Submit Inquiry (as Buyer)
    $response = $this->actingAs($buyerUser)->post(route('inquiries.store'), [
        'listing_id' => $listing->Listing_ID,
        'message' => 'Is this negotiable?'
    ]);
    $response->assertRedirect();
    $inquiry = Inquiry::where('User_ID', $buyerUser->User_ID)->first();
    expect($inquiry)->not->toBeNull();
    expect($inquiry->Message)->toBe('Is this negotiable?');

    // 9. Book a Visit (as Buyer)
    $response = $this->actingAs($buyerUser)->post(route('bookings.store'), [
        'property_id' => $property->Property_ID,
        'visit_date' => now()->addDays(2)->toDateString(),
        'visit_time' => '14:00',
    ]);
    $response->assertRedirect();
    $booking = Booking::where('User_ID', $buyerUser->User_ID)->first();
    expect($booking)->not->toBeNull();
    expect($booking->Booking_Status)->toBe('Pending');

    // 10. Confirm Booking (as Owner)
    $response = $this->actingAs($ownerUser)->post(route('bookings.confirm', $booking));
    $response->assertRedirect();
    expect($booking->refresh()->Booking_Status)->toBe('Confirmed');

    // 11. Complete Booking (as Owner)
    $response = $this->actingAs($ownerUser)->post(route('bookings.complete', $booking));
    $response->assertRedirect();
    expect($booking->refresh()->Booking_Status)->toBe('Completed');

    // 12. Submit Review (as Buyer)
    $response = $this->actingAs($buyerUser)->post(route('reviews.store'), [
        'Property_ID' => $property->Property_ID,
        'Booking_ID' => $booking->Booking_ID,
        'Rating' => 5,
        'Comment' => 'Excellent site visit experience!',
    ]);
    $response->assertRedirect();
    $review = Review::where('User_ID', $buyerUser->User_ID)->first();
    expect($review)->not->toBeNull();
    expect($review->Rating)->toBe(5);

    // 13. Submit Payment (as Buyer)
    $response = $this->actingAs($buyerUser)->post(route('payments.store'), [
        'Scheme_ID' => $scheme->Scheme_ID,
        'Amount' => 3000000,
        'Payment_Method' => 'Bank Transfer',
    ]);
    $response->assertRedirect();
    $payment = Payment::where('User_ID', $buyerUser->User_ID)->first();
    expect($payment->Amount)->toEqual(3000000);
});
