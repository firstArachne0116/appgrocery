<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'country_id' => 'required|integer|min:1',
            'city_id' => 'required|integer|min:1',
            'area_id' => 'required|integer|min:1',
            //'state_id' => 'required|integer|min:1',
            'address' => 'required|max:255',
            'email' => 'email|required|unique:vendors',
            'mobile' => 'integer|required',
            'status' => 'required|integer',
            'supermarket_id' => 'required|integer',
            'status' => 'required|integer',
        ];
    }
}
