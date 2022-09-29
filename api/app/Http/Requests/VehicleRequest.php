<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Model;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->state && Auth::user()->city;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function prepareForValidation()
    {
        
        if(isset($this->images) && count($this->images)>5){
            return response(['errors' => ['images' => ['Solo se pueden cargar hasta 5 imágenes']]], 422);
        }

        $category= Category::find($this->category_id);
        $brand= Brand::find($this->brand_id);
        $model= Model::find($this->model_id);

        if(isset($category) && isset($brand) && $brand->category->id != $category->id){
            $this->replace(
                $this->except(['brand_id', 'model_id'])
            );    
        }
        if(isset($category) && isset($brand) && isset($model) && $model->brand->id != $brand->id){
            $this->replace(
                $this->except(['model_id'])
            );       
        }

    }

    public function rules()
    {
        $rules = [
            'title' => ['required', 'max:80'],

            'price' => ['required', 'numeric', 'min:500', 'max:9999000'],
            'year' => ['required', 'numeric', 'min:1950', 'max:'.date("Y")],
            'mileage' => ['required', 'numeric', 'min:0','max:999000'],
            'description' => ['max:3000'],

            'fuel_id' => ['exists:fuels,id'],

            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['exists:brands,id'],
            'model_id' => ['exists:models,id'],
            'images' => ['required', 'array', 'min:1', 'max:5'],
        ];

        if($this->isMethod('PUT')){
            return array_merge($rules);
        }else{
            return array_merge($rules);
        }
    }
}
