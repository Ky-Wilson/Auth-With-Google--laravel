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
    public function authProviderRedirect($provider)
    {
        if($provider){
            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }


    public function socialAuthentication($provider)
    { try{
        if($provider){
$socialUser = Socialite::driver($provider)->stateless()->user();            $user = User::where('auth_provider_id', $socialUser->id)->first();
      
            if($user){
            Auth::login($user);
        }
        else{
            $userData = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'auth_provider_id' => $socialUser->id,
                'auth_provider' => $provider,
                'password' => Hash::make('PasseIci123!'),

            ]);
            if($userData){
                Auth::login($userData);
                return redirect()->route('dashboard');
            }
        }
           return redirect()->route('dashboard');
        }
        abort(404);

        
       }catch(\Exception $e){
        dd($e->getMessage());
       }
        
    }
    //
}
