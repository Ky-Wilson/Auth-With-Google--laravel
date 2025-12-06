<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        dd($googleUser);
    }
    //
}
