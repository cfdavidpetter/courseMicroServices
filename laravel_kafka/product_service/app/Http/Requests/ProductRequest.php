<?php

namespace App\Http\Requests;

use App\Http\Requests\Custom\CustomFormRequest;

class ProductRequest extends CustomFormRequest
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
            'name'          => 'required|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required',
            'qtd_available' => 'required',
            'qtd_total'     => 'required',
        ];
    }
}
