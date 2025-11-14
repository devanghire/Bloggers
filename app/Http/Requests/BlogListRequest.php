<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BlogListRequest extends FormRequest
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
            'user_id'  => 'required|integer|exists:users,id',
            'page'  => 'integer',
            'search_text' => 'nullable',
            'most_like'=> 'nullable|integer',
        ];
    }
    public function messages(): array
    {
        return [

            'user_id.required'     => 'User ID is required.',
            'user_id.integer'      => 'User ID must be numeric.',
            'user_id.exists'       => 'Invalid User ID.',
        ];
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
