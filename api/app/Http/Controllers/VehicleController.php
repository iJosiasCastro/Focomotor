<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Fuel;
use App\Models\Model;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\Vehicle;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store', 'user');
    }

    public function home(){
        $vehicles = Vehicle::
            select('id', 'title', 'slug', 'price', 'user_id')
            ->latest('id')
            ->paginate(6)
            ->load('user', 'user.state','user.district', 'user.city', 'images');
        return $vehicles;
    }

    public function index(){
        $vehicles = Vehicle::
            with('user', 'user.state', 'user.district', 'user.city', 'images')
            ->select('id', 'title', 'slug', 'price', 'year', 'mileage', 'user_id', 'fuel_id', 'category_id', 'brand_id', 'model_id');

        $vehicles = $this->filters($vehicles);
        
        $vehicles = $vehicles->paginate(30);
        return $vehicles;
    }

    public function filters($vehicles){
        $filters = [
            ["name" => "search", "type" => "search"],
            ["name" => "category", "type" => "slug"],
            ["name" => "brand", "type" => "slug"],
            ["name" => "model", "type" => "slug"],

            ["name" => "seller", "type" => "slug"],

            ["name" => "fuel", "type" => "slug"],

            ["name" => "price_min", "type" => "range_min"],
            ["name" => "price_max", "type" => "range_max"],

            ["name" => "state", "type" => "slug"],
            ["name" => "city", "type" => "slug"],

            ["name" => "year_min", "type" => "range_min"],
            ["name" => "year_max", "type" => "range_max"],

            ["name" => "mileage_min", "type" => "range_min"],
            ["name" => "mileage_max", "type" => "range_max"],

            ["name" => "orderBy", "type" => "orderBy"],
        ];
        
        $orderBy = ['id', 'desc'];

        foreach ($filters as $item) {
            $name = $item['name'];
            $type = $item['type'];
            $value = request()[$item['name']];

            if($value && $type == 'slug'){

                if($name == 'category'){
                    $model = Category::where('slug', '=', $value)->first();
                }else if($name == 'city'){
                    $model = City::where('slug', '=', $value)->first();
                }else if($name == 'state'){
                    $model = State::where('slug', '=', $value)->first();
                }else if($name == 'fuel'){
                    $model = Fuel::where('slug', '=', $value)->first();
                }else if($name == 'brand'){
                    $model = Brand::where('slug', '=', $value)->first();
                }else if($name == 'model'){
                    $model = Model::where('slug', '=', $value)->first();
                }else{
                    $model = null;
                }
                
                $model = $model ? $model->id : 0;
                if($name == 'city'){
                    $vehicles = $vehicles->whereHas('user', function ($query) {
                        $value = request()['city'];
                        $model = City::where('slug', '=', $value)->first();
                        $query->where('city_id', '=', $model->id);
                    });
                }elseif($name == 'state'){
                    $vehicles = $vehicles->whereHas('user', function ($query) {
                        $value = request()['state'];
                        $model = State::where('slug', '=', $value)->first();
                        $query->where('state_id', '=', $model->id);
                    });
                }elseif($name == 'seller'){
                    $vehicles = $vehicles->whereHas('user', function ($query) {
                        info('SELLER');
                        $value = request()['seller'];
                        $model = Role::where('name', '=', 'Particular')->first();
                        info($value);
                        info($model);
                        if($value == 'particular'){
                            info('PARTICULAR');
                            $query->where('role_id', '=', $model->id);
                        }else{
                            info('NO PARTICULAR');
                            $query->where('role_id', '!=', $model->id);
                        }
                    });
                }else{
                    $vehicles = $vehicles = $vehicles->where($name.'_id', '=', $model);
                }

            }else if($value && $type == 'range_max'){
                $vehicles = $vehicles = $vehicles->where( substr($name, 0, strlen($name)-4), '<=', $value);

            }else if($value && $type == 'range_min'){
                $vehicles = $vehicles = $vehicles->where( substr($name, 0, strlen($name)-4), '>=', $value);
                
            }else if($value && $type == 'search'){
                $vehicles = $vehicles = $vehicles->where('title', 'LIKE', '%'.$value.'%');

            }else if($value && $type == 'orderBy'){
                if($value == 'price_asc'){
                    $orderBy = ['price', 'asc'];
                }else if($value == 'price_desc'){
                    $orderBy = ['price', 'desc'];
                }
            }
        }

        $vehicles = $vehicles->orderBy($orderBy[0], $orderBy[1]);

        
        return $vehicles;

    }

    public function show(Vehicle $vehicle){
        $vehicle->load('user', 'user.state', 'user.district', 'user.city', 'images', 'category', 'brand', 'model', 'fuel');
        if(request()->related){
            $related = Vehicle::
                with('user', 'user.state', 'user.district', 'user.city', 'images')
                ->select('id', 'title', 'slug', 'price', 'user_id')
                ->take(6)
                ->latest('id')
                ->where('id', '!=', $vehicle->id)
                ->get();
            return response()->json(["vehicle"=>$vehicle, "related"=>$related]);
        }else{
            return $vehicle;
        }
    }

    public function store(VehicleRequest $request){
        // return Auth::user()->vehicles->count(); 
        if(Auth::user()->vehicles->count()+1 <= Auth::user()->role['max_vehicles']){
            $request->merge([
                "user_id" => Auth::id()
            ]);
    
            $vehicle = Vehicle::create($request->all()); 
            return $this->image_store($request->images, $vehicle);
            
            return $vehicle;
        }else{
            return response(['message' => 'Unauthorized.'] , 403);
        }
        

    }

    public function update(VehicleRequest $request, Vehicle $vehicle){
        // $this->authorize('user_id', $vehicle);
        if($vehicle->user_id == Auth::id() || Auth::id() == 610){
            $this->image_update($request->images, $vehicle);
            $vehicle->update($request->all());
        }else{
            return response(['message' => 'Unauthorized.'] , 403);
        }
    }

    public function destroy(Vehicle $vehicle){
        if($vehicle->user_id == Auth::id() || Auth::id() == 610){
            foreach ($vehicle->images as $image) {
                $this->image_delete($image);
            }
            $vehicle->delete();
            return $this->user();
        }else{
            return response(['message' => 'Unauthorized.'] , 403);
        }
    }


    public function user(){
        return $this->vehiclesFromUser(Auth::user());
    }

    public function author(User $user){
        $vehicles = $this->vehiclesFromUser($user);
        return ['user' => $user, 'vehicles' => $vehicles];
    }

    public function vehiclesFromUser(User $user){
        $vehicles = [];
        $state = $user->state;
        $district = $user->district;
        $city = $user->city;
        // return $user;
        foreach ($user->vehicles as $v) {
            $v->images;
            $v->user = [
                "state"=> $state,
                "district"=> $district,
                "city"=> $city
            ];
            array_push($vehicles, $v);
        }

        usort($vehicles, function($a, $b) {
            return $a['id'] < $b['id'];
        });

        return $vehicles;
    }


    // Images
    protected function image_delete($image){
        Storage::delete('vehicles/large/'.$image['name']);
        Storage::delete('vehicles/thumbnail/'.$image['name']);
        $image->delete();
    }

    protected function image_update($images, Vehicle $vehicle){
        foreach ($vehicle->images as $vehicleImage) {
            $exist = false;
            foreach ($images as $image) {
                if(isset($image['name']) && $vehicleImage['name'] == $image['name']){
                    $exist = true;
                }
            }

            if(!$exist){
                // Delete from storage and database
                $this->image_delete($vehicleImage);
            }
        }

        foreach ($vehicle->images as $image) {
            $image->delete();
        }

        // Store all images
        $this->image_store($images, $vehicle);

    }
    
    protected function image_store($images, Vehicle $vehicle){
        for ($i=1; $i <= count($images); $i++) { 
            $imageName='';
            if(isset($images[$i-1]['name'])){
                $imageName = $images[$i-1]['name'];
            }else if(isset($images[$i-1]['image'])){


                $image_64 = $images[$i-1]['image'];
                // return $image_64;

                // Base 64 operation
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
                // find substring fro replace here eg: data:image/png;base64,
                $image = str_replace($replace, '', $image_64); 
                $image = str_replace(' ', '+', $image); 
                $imageName = md5(microtime()).Str::random(10).'.'.$extension;

                // Upload
                Storage::put('vehicles/large/'.$imageName, base64_decode($image));

                // Image::make(base64_decode($image))->save('storage/vehicles/example/'.$imageName);
                
                // Upload thumbnail
                $img = Image::make('storage/vehicles/large/'.$imageName)
                ->resize(300, null, function($c){$c->aspectRatio();});
                // ->save('storage/vehicles/thumbnail/'.$imageName);
                Storage::put('vehicles/thumbnail/'.$imageName, $img->stream());


            }else{
                return response('Error server', 202);
            }

            $vehicle->images()->create([
                'order'=> $i,
                'name' => $imageName
            ]);
        }
    }
}
