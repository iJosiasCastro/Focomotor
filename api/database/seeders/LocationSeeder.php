<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use File;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $json = File::get("database/data/locations.json");

        $states = json_decode($json);
        foreach ($states as $state) {
            // Create state
            $stateCreated = State::create([
                'name' => $state->name,
            ]);

            if(isset($state->districts)){
                foreach ($state->districts as $district) {
                    // Create district
                    $districCreated = District::create([
                        'state_id' => $stateCreated->id,
                        'name' => $district->name,
                    ]);

                    foreach($district->cities as $city){
                        // Create city
                        City::create([
                            'name' => $city,
                            'cityable_id' => $districCreated->id,
                            'cityable_type' => District::class
                        ]);
                    }
                }

            }else if(isset($state->cities)){
                foreach($state->cities as $city){
                    // Create city
                    City::create([
                        'name' => $city,
                        'cityable_id' => $stateCreated->id,
                        'cityable_type' => State::class
                    ]);
    
                }
            }



        }
    }
}
