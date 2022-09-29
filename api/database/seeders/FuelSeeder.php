<?php

namespace Database\Seeders;

use App\Models\Fuel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use File;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/fuels.json');
        $fuels = json_decode($json);
        foreach ($fuels as $fuel) {
            Fuel::create([
                'name' => $fuel->name,
                // 'slug' => Str::slug($fuel->name)
            ]);
        }
    }
}
