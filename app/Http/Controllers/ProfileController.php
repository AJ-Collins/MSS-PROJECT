<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Handle the profile photo upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user already has a profile photo
        if ($user->profile_photo) {
            // Delete the old photo if it exists
            Storage::delete($user->profile_photo_url);
        }

        // Store the new image
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Update the user's profile photo path
        $user->profile_photo_url = $path;
        $user->save();

        // Return a JSON response
        return response()->json(['success' => true, 'profile_photo_url' => asset('storage/' . $path)]);
    }
}
