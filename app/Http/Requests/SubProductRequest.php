<?php

namespace App\Http\Requests;

use com_exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SubProductRequest extends FormRequest
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
    protected function failedValidation(Validator $validator)
    {
        $listErrors = $validator->errors()->all();
        $response = new JsonResponse([
            'message' => 'VALIDATION_FAILED',
            'errors' => $listErrors
        ], 422);

        throw new ValidationException($validator, $response);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'color_id' => 'required|integer',
            'size_id' => 'required|integer',
            'product_id' => 'required|integer',
            'image_url' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'color_id.required' => 'Color is required',
            'color_id.integer' => 'Color must be integer',
            'size_id.required' => 'Size is required',
            'size_id.integer' => 'Size must be integer',
            'product_id.required' => 'Product is required',
            'product_id.integer' => 'Product must be integer',
            'image_url.required' => 'Image is required',
            'image_url.string' => 'Image must be string',
        ];
    }
}
