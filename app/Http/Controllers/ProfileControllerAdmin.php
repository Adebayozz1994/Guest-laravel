<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileControllerAdmin extends Controller
{
    /**
     * Display the admin's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'admin' => Auth::guard('admin')->user(), // Using 'admin' guard
        ]);
    }

    /**
     * Update the admin's profile information.
     */
    public function update(AdminProfileUpdateRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user(); // Fetch admin
        // $admin->fill($request->validated());   // Update admin's data

        // Check if the email was changed
        // if ($admin->isDirty('email')) {
        //     $admin->email_verified_at = null;
        // }

        // $admin->save();  // Save changes

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the admin's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('adminDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $admin = Auth::guard('admin')->user();

        Auth::guard('admin')->logout();  // Log out the admin

        // $admin->delete();  // Delete the admin's account

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
