<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Particular', 'price' => 0, 'max_vehicles' => 1]); //1
        Role::create(['name' => 'x4', 'price' => 1000, 'max_vehicles' => 4]); //2
        Role::create(['name' => 'x10', 'price' => 2000, 'max_vehicles' => 10]); //3
        Role::create(['name' => 'x20', 'price' => 3000, 'max_vehicles' => 20]); //4
        Role::create(['name' => 'x50', 'price' => 6000, 'max_vehicles' => 50]); //5
        Role::create(['name' => 'x100', 'price' => 9000, 'max_vehicles' => 100]); //6
    }
}
