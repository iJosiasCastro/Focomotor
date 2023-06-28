<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VehicleController;
use App\Mail\ExpiredVehicleNotification;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    // Auth Controller
    'middleware' => 'api',
    'prefix' => 'auth'
], function(){

    Route::post('login', [AuthController::class, 'login']);
    Route::post('update', [AuthController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [AuthController::class, 'user']);

    Route::post('exist', [AuthController::class, 'existUser']);
    Route::get('user/vehicles', [VehicleController::class, 'user']);

    Route::post('reset_password_without_token', [AuthController::class, 'validatePasswordRequest']);
    Route::post('reset_password_with_token', [AuthController::class, 'resetPassword']);
    
});

Route::group([
    // Category Controller
    'middleware' => 'api',
], function(){
    Route::get('years', [CategoryController::class, 'years']);
    
    Route::get('categories', [CategoryController::class, 'categories']);
    Route::get('brands/{categoryId}', [CategoryController::class, 'brands']);
    Route::get('models/{categoryId}/{brandId}', [CategoryController::class, 'models']);
    
    Route::get('states', [CategoryController::class, 'states']);
    Route::get('cities/{stateId}', [CategoryController::class, 'cities']);
    
    Route::get('fuels', [CategoryController::class, 'fuels']);
    
});

Route::group([
    // Filter Controller
    'middleware' => 'api',
    'prefix' => 'filter'
], function(){
    Route::get('states', [FilterController::class, 'states']);
    Route::get('cities/{stateSlug}', [FilterController::class, 'cities']);
    
    Route::get('brands/{categorySlug}', [FilterController::class, 'brands']);
    Route::get('models/{categorySlug}/{brandSlug}', [FilterController::class, 'models']);

    Route::get('allCities', [FilterController::class, 'allCities']);
});


Route::group([
    // Vehicle Controller
    'middleware' => 'api',
], function(){
    Route::get('vehicles/home', [VehicleController::class, 'home']);
    Route::get('vehicles/{filters?}', [VehicleController::class, 'index']);
    Route::get('vehicles/author/{user}', [VehicleController::class, 'author']);

    Route::get('vehicle/{vehicle}', [VehicleController::class, 'show']);
    Route::post('vehicle', [VehicleController::class, 'store']);
    Route::put('vehicle/{vehicle}', [VehicleController::class, 'update']);
    Route::delete('vehicle/{vehicle}', [VehicleController::class, 'destroy']);
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'email'
], function(){
    Route::post('vehicle/{vehicle}', [MailController::class, 'message']);
    Route::post('contact', [MailController::class, 'contact']);
    Route::post('plan', [MailController::class, 'plan']);
});




Route::group(['middleware' => ['web']], function(){
    Route::get('/google-login', [SocialController::class, 'login']);
    Route::get('/google-callback', [SocialController::class, 'callback']);
});

Route::get('test', function(){
    $img = Image::make('https://images.pexels.com/photos/895259/pexels-photo-895259.jpeg?auto=compress&cs=tinysrgb&w=600')
    // $img = Image::make('storage/vehicles/large/6eed623ff0732d0d545592a8fcdbdd85eWM1G3VSY2.jpeg')
    ->resize(300, null, function($c){$c->aspectRatio();});
    Storage::put('vehicles/test.jpeg', $img->stream());

    return $img->response('jpg');
});

Route::get('delete-exipired-vehicles', function(){
    $expiredVehicles = Vehicle::whereDate('created_at', '<=', now()->subYear())
        ->with('user')
        ->whereHas('user', function ($query) {
            $query->where('role_id', 1);
        })
        ->get();


    foreach ($expiredVehicles as $vehicle) {

        $vehicle->delete();

        Mail::to($vehicle->user->email)->send(new ExpiredVehicleNotification([
            "title" => $vehicle->title,
            "name" => $vehicle->user->name
        ]));

    }

    return 'Expired vehicles deleted successfully.';
});