<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Fuel;
use App\Models\State;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(){
        $categories = Category::all();
        return $categories;
    }

    public function brands($id){
        $category = Category::findOrFail($id);
        $brands = $category->brands()->orderBy('name')->get();
        return $brands; 
    }

    public function models($id, $brandId){
        $category = Category::findOrFail($id);
        $brand = $category->brands()->findOrFail($brandId);
        $models = $brand->models()->orderBy('name')->get();
        return $models;
    }

    public function years(){
        $years = [];
        for ($i = (int)date("Y"); $i >= 1950; $i--) { 
            array_push($years, $i);
        }
        return $years;
    }

    public function states(){
        $states = State::all();
        return $states;
    }

    public function fuels(){
        return Fuel::all();
    }

    public function cities($id){
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

}
