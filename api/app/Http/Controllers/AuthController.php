<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateuserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\ResetPasswordMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Create a new AuthController instance.
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register', 'validatePasswordRequest', 'resetPassword', 'existUser']]);
    }

    // Get a JWT via given credentials.
    public function login(){
        // If social login complete return login
        if(request()->token){
            return $this->respondWithToken(request()->token);
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'La contraseña ingresada es incorrecta'], 401);
        }

        return $this->respondWithToken($token);
    }

    // Check if the email belongs to a user
    public function existUser(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:100'
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if(isset($user) && empty($user->password)){
            return 'google';
        }else if(isset($user)){
            return false;
        }else{
            return true;
        }
    }

    // Get the authenticated User.
    public function user()
    {
        $user = auth()->user();
        $user->state;
        $user->city;
        $user->district;
        $user->role;
        $user->vehicles_count = $user->vehicles->count();
        return $user;
    }

    // Log the user out (Invalidate the token).
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Se cerró la sesión correctamente']);
    }

    // Refresh a token.
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // Get the token array structure.
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // Register the user
    public function register(Request $request){
        $request->validate([
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $request->merge([
            "name" => explode('@', $request->email)[0],
            "password" => bcrypt($request->password),
            "role_id" => 1,
        ]);

        $user = User::create($request->all());

        $token = JWTAuth::fromUser($user);
        return $token;
    }

    // Update the user
    public function update(UserRequest $request){
        $user= Auth::user();
        $user->name = $request->name;
        $user->whatsapp = $request->whatsapp;
        $user->phone = $request->phone;
        $user->state_id = $request->state_id;
        $user->district_id = $request->district_id;
        $user->city_id = $request->city_id;
        
        $user->save();

        $token = JWTAuth::fromUser($user);
        return $token;
    }
    
    // Send a email with the password reset token
    public function validatePasswordRequest(Request $request){

        //You can add validation login here
        $user = User::where('email', '=', $request->email)->first();

        //Check if the user exists
        if (empty($user)) {
            return response()->json(['message'=>'No existe una cuenta registrada con ese correo'], 406);
        }
        $token = [
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ];
        DB::table('password_resets')->insert($token);

        $email = new ResetPasswordMailable($user, $token);
        Mail::to($user->email)->send($email);
        return response(['message'=>'Se envió el correo de recuperación, revisá tu email para continuar']);
    
        
    }


    // Reset the password with the token
    public function resetPassword(Request $request){
        //Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'token' => 'required'
        ]);

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData){
            return response()->json(['message'=>'El token no es válido'], 406);
        }

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user){
            return response()->json(['message'=>'El email no es válido'], 406);
        }
        //Hash and update the new password
        $user->password = bcrypt($password);
        $user->update(); //or $user->save();

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        $loginToken = JWTAuth::fromUser($user);
        return response(['message'=>'Tu contraseña fue cambiada correctamente', 'token' => $loginToken]);
    }


}