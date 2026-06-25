<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Property;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function show(Listing $listing)
    {
        $listing->load([
            'property.images', 'property.category',
            'property.owner.user', 'property.agent.user',
            'property.amenities', 'property.paymentSchemes',
            'property.reviews.user',
        ]);

        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = \App\Models\Favorite::where('User_ID', auth()->id())
                ->where('Listing_ID', $listing->Listing_ID)
                ->exists();
        }

        return view('listings.show', compact('listing', 'isFavorited'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->isOwner() && !$user->isAgent()) {
            abort(403, 'Only owners or agents can create listings.');
        }
        // Show only properties owned by this user (or assigned as agent)
        $properties = Property::where('Owner_ID', $user->User_ID)
            ->orWhere('Agent_ID', $user->User_ID)
            ->get();

        return view('listings.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isOwner() && !$user->isAgent()) {
            abort(403);
        }

        $validated = $request->validate([
            'Property_ID'   => 'required|integer|exists:property,Property_ID',
            'Listing_Type'  => 'required|in:Sale,Rent',
            'Price'         => 'required|numeric|min:0',
            'Listing_Date'  => 'required|date',
            'Expire_Date'   => 'required|date|after:Listing_Date',
            'Description'   => 'required|string',
            'Featured_Flag' => 'nullable|boolean',
        ]);

        Listing::create([
            'Property_ID'   => $validated['Property_ID'],
            'Created_By'    => $user->User_ID,
            'Listing_Type'  => $validated['Listing_Type'],
            'Price'         => $validated['Price'],
            'Listing_Date'  => $validated['Listing_Date'],
            'Expire_Date'   => $validated['Expire_Date'],
            'Status'        => 'Active',
            'Description'   => $validated['Description'],
            'Featured_Flag' => $request->boolean('Featured_Flag'),
            'Total_Views'   => 0,
        ]);

        return redirect()->route('dashboard', ['view' => auth()->user()->isOwner() ? 'Owner' : 'Agent'])
            ->with('success', 'Listing created successfully!');
    }

    public function edit(Listing $listing)
    {
        $this->authorizeListing($listing);
        $properties = Property::where('Owner_ID', auth()->id())
            ->orWhere('Agent_ID', auth()->id())
            ->get();
        return view('listings.edit', compact('listing', 'properties'));
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeListing($listing);

        $validated = $request->validate([
            'Listing_Type'  => 'required|in:Sale,Rent',
            'Price'         => 'required|numeric|min:0',
            'Expire_Date'   => 'required|date',
            'Description'   => 'required|string',
            'Status'        => 'required|in:Active,Inactive,Expired',
            'Featured_Flag' => 'nullable|boolean',
        ]);

        $listing->update([
            'Listing_Type'  => $validated['Listing_Type'],
            'Price'         => $validated['Price'],
            'Expire_Date'   => $validated['Expire_Date'],
            'Status'        => $validated['Status'],
            'Description'   => $validated['Description'],
            'Featured_Flag' => $request->boolean('Featured_Flag'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Listing updated!');
    }

    public function toggle(Listing $listing)
    {
        $this->authorizeListing($listing);
        $listing->update([
            'Status' => $listing->Status === 'Active' ? 'Inactive' : 'Active',
        ]);
        return back()->with('success', 'Listing status toggled.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorizeListing($listing);
        $listing->delete();
        return redirect()->route('dashboard')->with('success', 'Listing deleted.');
    }

    private function authorizeListing(Listing $listing): void
    {
        if ($listing->Created_By !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You do not have permission to manage this listing.');
        }
    }
}
