<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return $categories;
    }

    public function show($id){
        $category = Category::findOrFail($id);
        $brands = $category->brands()->orderBy('name')->get();
        return $brands; 
    }

    public function showBrand($id, $brandId){
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

}
