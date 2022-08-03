<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function citiesFilter(){
        $users = User::whereHas('vehicles')->get();

        $cities = [];
        foreach ($users as $user) {
            $find = false;
            foreach($cities as $city){
                if($city['slug'] == $user->city['slug']){
                    $find = true;
                }
            }
            if(!$find){
                array_push($cities, [
                    'name' => $user->city['name'],
                    'slug' => $user->city['slug']
                ]);
            }
        }

        usort($cities, function($a, $b) {
            return $a['name'] > $b['name'];
        });



        return $cities;
    }
}
