<?php

namespace Database\Seeders;

use App\Models\Image as ImageModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use Image;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/images.json");
        $data = json_decode($json);

        foreach ($data as $vehicle) {
            for ($i=1; $i <= count($vehicle->images); $i++) { 
                $name = md5(microtime()).Str::random(10).'.jpeg';
                Storage::copy($vehicle->images[$i-1], 'result/'.$name);
                ImageModel::create([
                    'name' => $name,
                    'order' => $i,
                    'vehicle_id' => $vehicle->vehicle_id 
                ]);
            }
        }

    }
}
