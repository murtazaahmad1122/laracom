<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
    
            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if ($user) {
                // If the user exists, log them in
                Auth::login($user);
            } else {
                // If the user doesn't exist, create them
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Generate a random password
                    'google_id' => $googleUser->getId(),
                ]);
    
                Auth::login($user);
            }
    
            // Redirect to home or intended page
            return redirect()->intended('/');
        } catch (\Exception $e) {
            // Handle exception, maybe log it or show a user-friendly error
            return redirect('/login')->with('error', 'Unable to login using Google.');
        }
    }
}
