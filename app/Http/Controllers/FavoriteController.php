<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Listing;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|integer|exists:listing,Listing_ID',
        ]);

        $userId    = auth()->id();
        $listingId = $request->listing_id;

        // Prevent duplicates
        $exists = Favorite::where('User_ID', $userId)
            ->where('Listing_ID', $listingId)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'User_ID'    => $userId,
                'Listing_ID' => $listingId,
                'Saved_Date' => now()->toDateString(),
            ]);
            return back()->with('success', 'Listing saved to favorites!');
        }

        return back()->with('info', 'This listing is already in your favorites.');
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->User_ID !== auth()->id()) {
            abort(403);
        }
        $favorite->delete();
        return back()->with('success', 'Removed from favorites.');
    }
}
