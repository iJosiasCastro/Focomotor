<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Josias Castro',
            'email' => 'josiascastro2003@gmail.com',
            'state_id' => 1,
            'city_id' => 1,
            'password' => bcrypt('2003@gmail'),
            'role_id' => 1,
        ]);

        // ->assignRole('Admin')
    }
}
