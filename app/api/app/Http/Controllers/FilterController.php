<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Fuel;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function states(){
        $allStates = State::orderBy("name")->get();
        $states = [];
        $hasVehicles = false;

        foreach($allStates as $state){
            $users = $state->users;
            $hasVehicles = false;
            foreach($users as $user){
                if(!$hasVehicles && count($user->vehicles)){
                    $hasVehicles = true;
                    array_push($states, ["id"=> $state->id, "name" => $state->name, "slug" => $state->slug]);
                }
            }
        }
        return $states;
    }

    public function cities($stateId){
        $state = State::findOrFail($stateId);

        $cities = [];
        $districts = [];

        if(count($state->cities)){
            $allCities = $state->cities()->orderBy('name')->get();
            foreach ($allCities as $city) {
                $find = false;
                foreach($city->users as $user){
                    if(!$find && count($user->vehicles)){
                        $find = true;
                        array_push($cities, ["id"=> $city->id, "name" => $city->name, "slug" => $city->slug]);
                    }
                }
            }
            return ["type" => "cities", "data" => $cities];

        }else {
            $allDistricts = $state->districts()->orderBy('name')->get();
            foreach ($allDistricts as $district) {
                $allCities = $district->cities()->orderBy('name')->get();

                // Get the cities with vehicles
                $cities = [];
                foreach ($allCities as $city) {
                    $find = false;
                    foreach($city->users as $user){
                        if(!$find && count($user->vehicles)){
                            array_push($cities, ["id"=> $city->id, "name" => $city->name, "slug" => $city->slug]);
                        }
                    }
                }

                // If the district has cities, push them
                if(count($cities)){
                    array_push($districts, [
                        "name"=> $district->id,
                        "name" => $district->name,
                        "slug" => $district->slug,
                        "cities" => $cities
                    ]);
                }
            }
            return ["type" => "districts", "data" => $districts]; 
        }
    }

    public function brands($categorySlug){
        $category = Category::where('slug', '=', $categorySlug)->first();
        if(empty($category)){
            return []; 
        }
        $allBrands = $category->brands;
        $brands = [];
        foreach ($allBrands as $brand) {
            if(count($brand->vehicles)){
                array_push($brands, ["id" => $brand->id, "name" => $brand->name, "slug" => $brand->slug]);
            }
        }
        return $brands;
    }

    public function models($categorySlug, $brandSlug){
        $category = Category::where('slug', '=', $categorySlug)->first();
        if(empty($category)){
            return []; 
        }
        $brand = Brand::where('slug', '=', $brandSlug)->first();
        if(empty($brand)){
            return []; 
        }

        $allModels = $brand->models()->orderBy('name')->get();
        $models = [];
        foreach ($allModels as $model) {
            if(count($model->vehicles)){
                array_push($models, ["id" => $model->id, "name" => $model->name, "slug" => $model->slug]);
            }
        }
        return $models;
    }

    public function allCities(){
        $users = User::whereHas('vehicles')->get();
        
        $cities = [];
        foreach ($users as $user) {
            $find = false;
            foreach($cities as $city){
                if($city['slug'] == $user->city['slug']){
                    $find = true;
                }
            }
            // No add duplicates cities
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
