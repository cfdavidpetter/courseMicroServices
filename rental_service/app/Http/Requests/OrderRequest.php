<?php

namespace App\Http\Requests;

use App\Http\Requests\Custom\CustomFormRequest;

class OrderRequest extends CustomFormRequest
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
            'customer_id'   => 'required',
            'status'        => 'required',
            'discount'      => 'required',
            'downpayment'   => 'required',
            'delivery_fee'  => 'required',
            'late_fee'      => 'required',
            'order_date'    => 'required',
            'return_date'   => 'required',

            'items.*.product_id'    => 'required',
            'items.*.qtd'           => 'required',
        ];
    }
}
