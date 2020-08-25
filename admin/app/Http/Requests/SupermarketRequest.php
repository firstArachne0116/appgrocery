<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupermarketRequest extends FormRequest
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
            'name_arabic' => 'required|max:255',
            'country_id' => 'required|integer|min:1',
            'city_id' => 'required|integer|min:1',
            'area_id' => 'required|integer|min:1',
           // 'state_id' => 'required|integer|min:1',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|max:255',
            'freedeliveryamount' => 'integer|min:1',
            'fixeddeliveryamount' => 'integer|min:1',
            'fixedserviceamount' => 'integer|min:1',
            'commission_percentage' => 'integer|min:1|max:99',
            'cash_money' => 'integer|min:1',
            'deliverytime' => 'required|max:255',
            'status' => 'required|integer',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ];
    }
}
