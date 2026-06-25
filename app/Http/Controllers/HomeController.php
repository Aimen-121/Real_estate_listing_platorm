<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredListings = Listing::with(['property.images', 'property.category', 'property.owner.user'])
            ->where('Status', 'Active')
            ->where('Featured_Flag', true)
            ->orderBy('Listing_ID', 'desc')
            ->limit(6)
            ->get();

        $latestListings = Listing::with(['property.images', 'property.category'])
            ->where('Status', 'Active')
            ->orderBy('Listing_ID', 'desc')
            ->limit(8)
            ->get();

        $categories = PropertyCategory::withCount('properties')->get();

        $popularCities = Property::select('City')
            ->selectRaw('COUNT(*) as property_count')
            ->groupBy('City')
            ->orderByDesc('property_count')
            ->limit(6)
            ->get();

        return view('home', compact('featuredListings', 'latestListings', 'categories', 'popularCities'));
    }
}
