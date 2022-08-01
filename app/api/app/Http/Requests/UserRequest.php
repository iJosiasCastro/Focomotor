<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\District;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if(isset($this->whatsapp)==''){
            $this->replace(
                $this->except(['whatsapp'])
            );
        }

        if(isset($this->phone)==''){
            $this->replace(
                $this->except(['phone'])
            );
        }

        $state= State::find($this->state_id);
        $district= District::find($this->district_id);
        $city= City::find($this->city_id);

        if(isset($state) && !isset($district)){
            $this->replace(
                $this->except(['district_id'])
            );  
        }

        if(isset($state) && isset($city) && !isset($district) && $city->cityable->id != $state->id){
            $this->replace(
                $this->except(['city_id'])
            );       
        }

        if(isset($state) && isset($district) && $district->state->id != $state->id){
            $this->replace(
                $this->except(['district_id', 'city_id'])
            );    
        }

        if(isset($state) && isset($district) && isset($city) && $city->cityable->id != $district->id){
            $this->replace(
                $this->except(['city_id'])
            );       
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:100',
            // 'email' => 'required|string|email|max:100|unique:users',
            // 'password' => 'required|string|min:6',
            
            'whatsapp' => 'numeric|min:100000|max:9999999999999',
            'phone' => 'numeric|min:100000|max:9999999999999',

            'state_id' => ['required', 'exists:states,id'],
            'district_id' => ['exists:districts,id'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }
}
