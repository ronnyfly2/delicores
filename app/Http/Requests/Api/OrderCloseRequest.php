<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderCloseRequest extends FormRequest
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
                'order' => 'required|array',

                'order.name' => 'required|string',
                'order.last_name' => 'required|string',
                'order.email' => 'required|email',
                'order.phone' => 'required|string',
                'order.address' => 'required|string',

                'order.latitude' => 'required|string',
                'order.longitude' => 'required|string',


                'delivery_price' => 'required|array',
                'delivery_price._id' => 'required|string',


                'payment_type' => 'required|array',
                'payment_type._id' => 'required|string',
            ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json(['success' => 'error', 'errors' => $validator->errors()->toArray(), 'message' => _i('La operación no pudo ser completada.')], 400));

    }
}
