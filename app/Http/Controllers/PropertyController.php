<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyImage;
use App\Models\Amenity;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /** Public search / browse – no auth needed */
    public function search(Request $request)
    {
        $query = Property::with(['images', 'category', 'owner.user', 'agent.user'])
            ->where('Availability_Status', '!=', 'Sold');

        if ($request->filled('city')) {
            $query->where('City', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('Category_ID', $request->category_id);
        }
        if ($request->filled('type')) {
            $query->where('Property_Type', $request->type);
        }
        if ($request->filled('min_price')) {
            $query->where('Price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('Price', '<=', $request->max_price);
        }
        if ($request->filled('bedrooms')) {
            $query->where('Bedrooms', '>=', $request->bedrooms);
        }
        if ($request->filled('bathrooms')) {
            $query->where('Bathrooms', '>=', $request->bathrooms);
        }
        if ($request->filled('availability')) {
            $query->where('Availability_Status', $request->availability);
        }

        $sortMap = [
            'newest'      => ['Property_ID', 'desc'],
            'oldest'      => ['Property_ID', 'asc'],
            'price_asc'   => ['Price', 'asc'],
            'price_desc'  => ['Price', 'desc'],
        ];
        [$col, $dir] = $sortMap[$request->sort ?? 'newest'];
        $query->orderBy($col, $dir);

        //$properties  = $query->paginate(12)->withQueryString();//
        $properties = $query->with(['images', 'listings' => function ($q) {
            $q->where('Status', 'Active');
        }])->paginate(12)->withQueryString();
        $categories  = PropertyCategory::all();

        return view('properties.search', compact('properties', 'categories'));
    }

    /** Public detail view */
    public function show(Property $property)
    {
        $property->load([
            'images', 'category', 'owner.user', 'agent.user',
            'amenities', 'listings', 'paymentSchemes', 'reviews.user',
        ]);

        // Increment listing views if an active listing exists
        if ($listing = $property->listings->where('Status', 'Active')->first()) {
            $listing->increment('Total_Views');
        }

        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = \App\Models\Favorite::where('User_ID', auth()->id())
                ->whereIn('Listing_ID', $property->listings->pluck('Listing_ID'))
                ->exists();
        }

        return view('properties.show', compact('property', 'isFavorited'));
    }

    /** Create form (Owner only) */
    public function create()
    {
        $this->authorizeOwner();
        $categories = PropertyCategory::all();
        $amenities  = Amenity::all();
        return view('properties.create', compact('categories', 'amenities'));
    }

    /** Store new property */
    public function store(Request $request)
    {
        $this->authorizeOwner();

        $validated = $request->validate([
            'Title'               => 'required|string|max:150',
            'Description'         => 'required|string',
            'Location'            => 'required|string|max:255',
            'City'                => 'required|string|max:100',
            'State'               => 'required|string|max:100',
            'Zip_Code'            => 'nullable|string|max:20',
            'Category_ID'         => 'required|integer|exists:property_category,Category_ID',
            'Property_Type'       => 'required|string|max:50',
            'Area_Size'           => 'required|numeric|min:1',
            'Bedrooms'            => 'nullable|integer|min:0',
            'Bathrooms'           => 'nullable|integer|min:0',
            'Price'               => 'required|numeric|min:0',
            'Availability_Status' => 'required|string|max:30',
            'amenities'           => 'nullable|array',
            'amenities.*'         => 'integer|exists:amenity,Amenity_ID',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $property = Property::create([
            'Owner_ID'            => auth()->id(),
            'Agent_ID'            => null,
            'Category_ID'         => $validated['Category_ID'],
            'Title'               => $validated['Title'],
            'Description'         => $validated['Description'],
            'Location'            => $validated['Location'],
            'City'                => $validated['City'],
            'State'               => $validated['State'],
            'Zip_Code'            => $validated['Zip_Code'] ?? null,
            'Area_Size'           => $validated['Area_Size'],
            'Bedrooms'            => $validated['Bedrooms'] ?? 0,
            'Bathrooms'           => $validated['Bathrooms'] ?? 0,
            'Property_Type'       => $validated['Property_Type'],
            'Price'               => $validated['Price'],
            'Availability_Status' => $validated['Availability_Status'],
        ]);

        // Sync amenities
        if (!empty($validated['amenities'])) {
            $property->amenities()->sync($validated['amenities']);
        }

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                //$path = $img->store('properties', 'public');//
                $filename = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('images'), $filename);
                PropertyImage::create([
                    'Property_ID' => $property->Property_ID,
                    'Image_Path'  => $filename,
                    'Upload_Date' => now()->toDateString(),
                    'Caption'     => $property->Title,
                ]);
            }
        }

        return redirect()->route('dashboard', ['view' => 'Owner'])
            ->with('success', 'Property added successfully!');
    }

    /** Edit form */
    public function edit(Property $property)
    {
        $this->authorizePropertyOwner($property);
        $categories = PropertyCategory::all();
        $amenities  = Amenity::all();
        $property->load('amenities', 'images');
        return view('properties.edit', compact('property', 'categories', 'amenities'));
    }

    /** Update property */
    public function update(Request $request, Property $property)
    {
        $this->authorizePropertyOwner($property);

        $validated = $request->validate([
            'Title'               => 'required|string|max:150',
            'Description'         => 'required|string',
            'Location'            => 'required|string|max:255',
            'City'                => 'required|string|max:100',
            'State'               => 'required|string|max:100',
            'Zip_Code'            => 'nullable|string|max:20',
            'Category_ID'         => 'required|integer|exists:property_category,Category_ID',
            'Property_Type'       => 'required|string|max:50',
            'Area_Size'           => 'required|numeric|min:1',
            'Bedrooms'            => 'nullable|integer|min:0',
            'Bathrooms'           => 'nullable|integer|min:0',
            'Price'               => 'required|numeric|min:0',
            'Availability_Status' => 'required|string|max:30',
            'amenities'           => 'nullable|array',
            'amenities.*'         => 'integer|exists:amenity,Amenity_ID',
        ]);

        $property->update($validated);

        if (isset($validated['amenities'])) {
            $property->amenities()->sync($validated['amenities']);
        } else {
            $property->amenities()->detach();
        }

        return redirect()->route('dashboard', ['view' => 'Owner'])
            ->with('success', 'Property updated successfully!');
    }

    /** Delete property */
    public function destroy(Property $property)
    {
        $this->authorizePropertyOwner($property);
        // Delete associated images from storage
        foreach ($property->images as $img) {
            Storage::disk('public')->delete($img->Image_Path);
        }
        $property->delete();

        return redirect()->route('dashboard', ['view' => 'Owner'])
            ->with('success', 'Property deleted successfully.');
    }

    /** Upload additional images to an existing property */
    public function uploadImages(Request $request, Property $property)
    {
        $this->authorizePropertyOwner($property);
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($request->file('images') as $img) {
            $path = $img->store('properties', 'public');
            PropertyImage::create([
                'Property_ID' => $property->Property_ID,
                'Image_Path'  => $path,
                'Upload_Date' => now()->toDateString(),
                'Caption'     => $request->input('caption', $property->Title),
            ]);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    /** Delete a single image */
    public function deleteImage(Property $property, PropertyImage $image)
    {
        $this->authorizePropertyOwner($property);
        Storage::disk('public')->delete($image->Image_Path);
        $image->delete();
        return back()->with('success', 'Image deleted.');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────
    private function authorizeOwner(): void
    {
        if (!auth()->user()->isOwner()) {
            abort(403, 'Only property owners can perform this action.');
        }
    }

    private function authorizePropertyOwner(Property $property): void
    {
        if ($property->Owner_ID !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You do not have permission to manage this property.');
        }
    }
}
