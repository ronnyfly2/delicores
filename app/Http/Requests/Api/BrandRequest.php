<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandRequest extends FormRequest
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
            'brand' => 'required|array',
            'brand.name' => 'required|string',
            'brand.slug' => 'required|string'
        ];
    }


    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json(['success' => 'error', 'errors' => $validator->errors()->toArray(), 'message' => _i('La operación no pudo ser completada.')], 400));

    }
}
