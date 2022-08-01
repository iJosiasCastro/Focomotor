<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function login () {
        return Socialite::driver('google')->stateless()->redirect();
    }

    protected function loginGoogle($user)
    {
        Auth::login($user);
        $token = JWTAuth::fromUser($user);
        // return $token;
        return redirect(env('CLIENT_URL').'google-login?token='.$token);
    } 

    public function callback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $userExist = User::where('email', $user->email)->first();
        
        if($userExist){
            $userSocialExist = User::where('external_id', $user->id)->where('external_auth', 'google')->first();
            if($userSocialExist){
                return $this->loginGoogle($userSocialExist);
            }else{
                $userExist->external_id = $user->id;
                $userExist->external_auth = 'google';
                $userExist->save();
                return $this->loginGoogle($userExist);
            }
        }else{
            $userNew = User::create([
                'name' => $user->name,
                'email' => $user->email,
                
                'external_id' => $user->id,
                'external_auth' => 'google',
                'role_id' => 1
            ]);
            return $this->loginGoogle($userNew);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
