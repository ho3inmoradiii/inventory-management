<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'required',
            'product_name' => 'required',
            'product_code' => 'required',
            'buying_price' => 'nullable',
            'selling_price' => 'required',
            'supplier_id' => 'required',
            'buying_date' => 'nullable',
            'product_quantity' => 'required',
        ];
    }
}
