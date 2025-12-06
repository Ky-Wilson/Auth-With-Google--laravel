<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialliteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback from Google

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();
       try{
            if($user){
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        else{
            $userData = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make('PasseIci123!'),
            ]);
            if($userData){
                Auth::login($userData);
                return redirect()->route('dashboard');
            }
        }
       }catch(\Exception $e){
        dd($e->getMessage());
       }
        
    }
    //
}
