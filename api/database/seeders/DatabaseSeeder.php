<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('vehicles');
        Storage::makeDirectory('vehicles');

        $this->call(RoleSeeder::class);

        $this->call(FuelSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CategorySeeder::class);

        $this->call(UserSeeder::class);
        $this->call(VehicleSeeder::class);

        $this->call(WordpressSeeder::class);
    }
}
