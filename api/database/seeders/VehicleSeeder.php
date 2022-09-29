<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = Vehicle::factory(20)->create();
        foreach ($vehicles as $vehicle) {
            for ($i=1; $i <= 5; $i++) { 
                Image::factory(1)->create([
                    'order' => $i,
                    'vehicle_id' => $vehicle->id 
                ]);
                // if($i==0){
                //     $vehicle->thumbnail = $image->url;
                //     $vehicle->save();
                // }
            }
        }
    }
}
