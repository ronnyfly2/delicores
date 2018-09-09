<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'product' => 'required|array',

            'product.name' => 'required|string',
            'product.slug' => 'required|string',

            'product.description' => 'required|string',

            'product.price1' => 'required|string',
            'product.price2' => 'required|string',
            'product.price3' => 'required|string',

            'brand._id' => 'required|valid_brand',

            'categories' => 'array',
            'categories.*._id' => 'valid_category',

            'categories.*.subcategories' => 'array',
            'categories.*.subcategories.*._id' => 'valid_subcategory'
        ];
    }

    public function messages()
    {
        return [
            'product.brand_id.valid_brand' => _i('La marca ingresada no es válida.'),
            'categories.*._id.valid_category' => _i('La categoria ingresada no es válida.'),
            'categories.*.subcategories.*._id.valid_subcategory' => _i('La subcategoria ingresada no es válida.'),
        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json(['success' => 'error', 'errors' => $validator->errors()->toArray(), 'message' => _i('La operación no pudo ser completada.')], 400));

    }
}
