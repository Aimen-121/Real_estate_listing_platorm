<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Buyer;
use App\Models\Owner;
use App\Models\Renter;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Full_Name' => ['required', 'string', 'max:100'],
            'Email' => ['required', 'string', 'email', 'max:100', 'unique:user,Email'],
            'Phone_Number' => ['nullable', 'string', 'max:20'],
            'Identity_Type' => ['nullable', 'string', 'max:20'],
            'Identity_Number' => ['nullable', 'string', 'max:50'],
            'Password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'in:buyer,renter,owner,agent,admin'],
        ]);

        $user = User::create([
            'Full_Name' => $request->Full_Name,
            'Email' => $request->Email,
            'Phone_Number' => $request->Phone_Number,
            'Identity_Type' => $request->Identity_Type,
            'Identity_Number' => $request->Identity_Number,
            'Password' => Hash::make($request->Password),
            'Registration_Date' => now()->toDateString(),
            'Status' => 'Active',
        ]);

        // Insert subtype records based on selection to support overlapping roles
        $roles = $request->input('roles', []);

        if (in_array('buyer', $roles)) {
            Buyer::create([
                'User_ID' => $user->User_ID,
                'Preference' => 'House',
            ]);
        }

        if (in_array('renter', $roles)) {
            Renter::create([
                'User_ID' => $user->User_ID,
                'Move_In_Date' => now()->addMonth()->toDateString(),
            ]);
        }

        if (in_array('owner', $roles)) {
            Owner::create([
                'User_ID' => $user->User_ID,
                'Ownership_Type' => 'Individual',
            ]);
        }

        if (in_array('agent', $roles)) {
            Agent::create([
                'User_ID' => $user->User_ID,
                'Agency_Name' => 'Independent Agency',
                'License_Number' => 'LIC-'.rand(10000, 99999),
                'Experience_Years' => 0,
                'Rating' => 5.0,
            ]);
        }

        if (in_array('admin', $roles)) {
            Admin::create([
                'User_ID' => $user->User_ID,
                'Admin_Role' => 'Administrator',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
