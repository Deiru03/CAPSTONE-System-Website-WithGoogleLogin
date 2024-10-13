<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
            //dd($google_user); //debug purposes

            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'user_type' => 'Faculty',
                    'clearances_status' => 'pending',
                ]);

                Auth::login($new_user);

                return redirect()->intended('dashboard');
            }
            else {
                Auth::login($user);

                return redirect()->intended('dashboard');
            }
        } catch (\Exception $e) {
            dd('something went wrong', $e->getMessage());
        }
    }
}
