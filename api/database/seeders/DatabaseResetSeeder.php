<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = storage_path('framework/cache/data');
        info($data);
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // DB::table('brands')->truncate();
        // DB::table('categories')->truncate();
        // DB::table('cities')->truncate();
        // DB::table('districts')->truncate();
        // DB::table('failed_jobs')->truncate();
        // DB::table('fuels')->truncate();
        // DB::table('images')->truncate();
        // DB::table('migrations')->truncate();
        // DB::table('models')->truncate();
        // DB::table('password_resets')->truncate();
        // DB::table('personal_access_tokens')->truncate();
        // DB::table('roles')->truncate();
        // DB::table('states')->truncate();
        // DB::table('users')->truncate();
        // DB::table('vehicles')->truncate();
        
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
