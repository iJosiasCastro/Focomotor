<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function index(){
        $states = State::all();
        return $states;
    }

    public function show($id){
        $state = State::findOrFail($id);
        if(count($state->cities)){
            $cities = $state->cities()->orderBy('name')->get();
            return ["type" => "cities", "data" => $cities]; 
        }else{
            $districts = $state->districts()->orderBy('name')->get();
            foreach ($districts as $district) {
                $district->cities;
            }
            return ["type" => "districts", "data" => $districts]; 
        }
    }

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
        // $cities = [];
        // foreach ($users as $user) {
        //     $exist = false;

        //     if(!$exist){
        //         array_push($cities, [
        //             'name' => $user->city['name'],
        //             'slug' => $user->city['slug']
        //         ]);
        //     }
        // }
        // return $cities;
    }
}
