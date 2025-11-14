<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BlogLikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blogid'  => 'required|integer|exists:blogs,id',
        ];
    }
    public function messages(): array
    {
        return [
            'blogid.required'     => 'Blog ID is required.',
            'blogid.integer'      => 'Blog ID must be numeric.',
            'blogid.exists'       => 'Invalid Blog ID.',
        ];
    }

    public function validationData()
    {
        return $this->query();
    }
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'code' => 422,
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
