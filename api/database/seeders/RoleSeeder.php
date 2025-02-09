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
        Role::create(['name' => 'x10', 'price' => 15000, 'max_vehicles' => 10]); //2
        Role::create(['name' => 'x50', 'price' => 30000, 'max_vehicles' => 50]); //3
        Role::create(['name' => 'x120', 'price' => 50000, 'max_vehicles' => 120]); //4
    }
}
