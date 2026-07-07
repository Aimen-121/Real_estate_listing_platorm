<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.destroy');

    // Properties
    Route::get('/properties', [AdminDashboardController::class, 'properties'])->name('properties');
    Route::post('/properties/{property}/assign-agent', [AdminDashboardController::class, 'assignAgent'])->name('properties.assign-agent');
    Route::delete('/properties/{property}', [AdminDashboardController::class, 'deleteProperty'])->name('properties.destroy');

    // Listings
    Route::get('/listings', [AdminDashboardController::class, 'listings'])->name('listings');
    Route::post('/listings/{listing}/toggle', [AdminDashboardController::class, 'toggleListingStatus'])->name('listings.toggle');
    Route::delete('/listings/{listing}', [AdminDashboardController::class, 'deleteListing'])->name('listings.destroy');

    // Categories
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminDashboardController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.destroy');

    // Amenities
    Route::get('/amenities', [AdminDashboardController::class, 'amenities'])->name('amenities');
    Route::post('/amenities', [AdminDashboardController::class, 'storeAmenity'])->name('amenities.store');
    Route::put('/amenities/{amenity}', [AdminDashboardController::class, 'updateAmenity'])->name('amenities.update');
    Route::delete('/amenities/{amenity}', [AdminDashboardController::class, 'deleteAmenity'])->name('amenities.destroy');

    // Bookings
    Route::get('/bookings', [AdminDashboardController::class, 'bookings'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [AdminDashboardController::class, 'updateBookingStatus'])->name('bookings.status');
    Route::delete('/bookings/{booking}', [AdminDashboardController::class, 'deleteBooking'])->name('bookings.destroy');

    // Inquiries
    Route::get('/inquiries', [AdminDashboardController::class, 'inquiries'])->name('inquiries');
    Route::patch('/inquiries/{inquiry}/status', [AdminDashboardController::class, 'updateInquiryStatus'])->name('inquiries.status');
    Route::delete('/inquiries/{inquiry}', [AdminDashboardController::class, 'deleteInquiry'])->name('inquiries.destroy');

    // Reviews
    Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{review}', [AdminDashboardController::class, 'deleteReview'])->name('reviews.destroy');

    // Payments
    Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
    Route::patch('/payments/{payment}/status', [AdminDashboardController::class, 'updatePaymentStatus'])->name('payments.status');
});
