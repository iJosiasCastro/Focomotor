<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VehicleController;
use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('exist', [AuthController::class, 'exist']);
    Route::post('update', [AuthController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [AuthController::class, 'user']);
    Route::get('user/vehicles', [VehicleController::class, 'user']);
    
});
Route::get('author/{user}', [VehicleController::class, 'author']);

Route::get('years', [CategoryController::class, 'years']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{categoryId}', [CategoryController::class, 'show']);
Route::get('categories/{categoryId}/{brandId}', [CategoryController::class, 'showBrand']);

Route::get('cities_filter', [LocationController::class, 'citiesFilter']);

Route::get('states', [LocationController::class, 'index']);
Route::get('states/{stateId}', [LocationController::class, 'show']);
// Route::get('states/{stateId}/{districtId}', [LocationController::class, 'showDistrict']);

Route::get('fuels', function(){return Fuel::all();});


Route::get('vehicles/home', [VehicleController::class, 'home']);
Route::get('vehicles/{filters?}', [VehicleController::class, 'index']);
Route::get('vehicle/{vehicle}', [VehicleController::class, 'show']);

Route::post('vehicle', [VehicleController::class, 'store']);
Route::put('vehicle/{vehicle}', [VehicleController::class, 'update']);
Route::delete('vehicle/{vehicle}', [VehicleController::class, 'destroy']);

Route::post('message/{vehicle}', [MailController::class, 'message']);

Route::post('contact', [MailController::class, 'contact']);

Route::group(['middleware' => ['web']], function () {
    Route::get('/google-login', [SocialController::class, 'login']);
    Route::get('/google-callback', [SocialController::class, 'callback']);
});

Route::get('test', function(){
    // $img = Image::make('storage/vehicles/large/271f70ae04b86dbebf4e5f642d78d972eglv8F669u.jpeg')
    // ->resize(300, null, function($c){$c->aspectRatio();});
    // Storage::put('vehicles/test.jpeg', $img->stream());

    // return $img->response('jpg');
});

Route::post('reset_password_without_token', [AuthController::class, 'validatePasswordRequest']);
Route::post('reset_password_with_token', [AuthController::class, 'resetPassword']);
    

Route::post('plan/email', [MailController::class, 'plan']);
