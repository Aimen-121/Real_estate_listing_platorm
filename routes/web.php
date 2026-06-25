<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ─── Public Home & Property Search ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// ─── Authenticated Routes ───────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Properties ──────────────────────────────────────────────────────────
    Route::resource('properties', PropertyController::class)->except(['index']);
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    // Property Images
    Route::post('/properties/{property}/images', [PropertyController::class, 'uploadImages'])
        ->name('properties.images.upload');
    Route::delete('/properties/{property}/images/{image}', [PropertyController::class, 'deleteImage'])
        ->name('properties.images.destroy');

    // ── Listings ────────────────────────────────────────────────────────────
    Route::resource('listings', ListingController::class)->except(['show']);
    Route::post('/listings/{listing}/toggle', [ListingController::class, 'toggle'])
        ->name('listings.toggle');

    // ── Favorites ───────────────────────────────────────────────────────────
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // ── Inquiries ───────────────────────────────────────────────────────────
    Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
    Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])
        ->name('inquiries.status');

    // ── Bookings ────────────────────────────────────────────────────────────
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
        ->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])
        ->name('bookings.complete');

    // ── Reviews ─────────────────────────────────────────────────────────────
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // ── Payments ────────────────────────────────────────────────────────────
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

require __DIR__.'/auth.php';
