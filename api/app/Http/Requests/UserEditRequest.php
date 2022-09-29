<?php

namespace App\Http\Requests;

use App\Models\City;
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
        $state= State::find($this->state_id);
        $city= City::find($this->city_id);
        if(isset($state) && isset($city) && $city->state->id != $state->id){
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
            
            'whatsapp' => 'numeric|min:100000|max:99999999999',

            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }
}
