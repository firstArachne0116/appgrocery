<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'supermarket_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'lottery_product' => 'required|integer',
            'lottery_winner' => 'required|integer',
            'lottery_id' => 'required|integer',
            'category_id' => 'required|integer',
            'name' => 'required|max:255',
            'description' => 'required|max:1023',
            'price' => 'integer|required|min:1',
            'discount' => 'integer|required|min:0|max:100',
            'capacity' => 'integer|required|min:0|',
            'quantity' => 'integer|required|min:0|',
            'filename' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
