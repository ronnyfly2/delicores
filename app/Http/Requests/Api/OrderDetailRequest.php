<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderDetailRequest extends FormRequest
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
        $rules = [
                'product' => 'required|array',

                'product.quantity' => 'required|numeric|min:1',
            ];

        if($this->method == 'POST')
            $rules['product._id'] = 'required|string';

        return $rules;
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json(['success' => 'error', 'errors' => $validator->errors()->toArray(), 'message' => _i('La operación no pudo ser completada.')], 400));

    }
}
