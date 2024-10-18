<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Check if a user with the same email already exists
            $user = User::where('email', $google_user->getEmail())->first();

            if ($user) {
                // If the user exists but doesn't have a google_id, update it
                if (!$user->google_id) {
                    $user->update(['google_id' => $google_user->getId()]);
                }
                if (!$user->profile_picture) {
                    $user->update(['profile_picture' => $google_user->getAvatar()]);
                }
                
            } else {
                // Create a new user if it doesn't exist
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'profile_picture' => $google_user->getAvatar(),
                    'google_id' => $google_user->getId(),
                    'user_type' => 'Faculty',
                    'clearances_status' => 'pending',
                ]);
            }

            Auth::login($user);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google login error: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->route('login')->with('error', 'Failed to login with Google. Please try again.');
        }
    }
}
