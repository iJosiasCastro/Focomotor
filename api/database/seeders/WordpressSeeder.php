<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use File;
use Illuminate\Support\Facades\Storage;

class WordpressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = File::get("database/data/wordpress/users.json");
        $users = json_decode($users);

        foreach ($users as $user) {
            User::create([
                "name" => $user->name,
                "role_id" => 1,
                "email" => $user->email,
                "phone" => $user->phone,
                "state_id" => $user->state_id,
                "district_id" => $user->district_id,
                "city_id" => $user->city_id,
            ]);
        }

        $vehicles = File::get("database/data/wordpress/vehicles.json");
        $vehicles = json_decode($vehicles);

        foreach ($vehicles as $vehicle) {
            Vehicle::create([
                "title" => $vehicle->Title,
                "price" => $vehicle->Price,
                "year" => $vehicle->Year,
                "mileage" => $vehicle->Mileage,
                "description" => $vehicle->description,
                "fuel_id" => $vehicle->Fuel_id,
                "category_id" => $vehicle->Category_id,
                "brand_id" => $vehicle->Brand_id,
                "model_id" => $vehicle->Model_id,
                "user_id" => $vehicle->user_id,
            ]);
        }

        $images = File::get("database/data/wordpress/images.json");
        $images = json_decode($images);

        foreach ($images as $image) {
            // $vehicle = Vehicle::find($image->vehicle_id);
            // if(isset($vehicle)){
                if(Storage::exists('vehicles/large/' . $image->name)){
                    Image::create([
                        "name" => $image->name,
                        "order" => $image->order,
                        "vehicle_id" => (int)$image->vehicle_id
                    ]);
                };
            // }
        }

        // Id de vehiculos por eliminar
        // 293, 361, 360, 359

        

    }
}
