<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;



class BlogRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'user_id'     => 'required|integer|exists:users,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:50000', //50mb
        ];
    }
    public function messages(): array
    {
        return [
            'title.required'       => 'Blog title is required.',
            'description.required' => 'Blog description is required.',
            'user_id.required'     => 'User ID is required.',
            'user_id.integer'      => 'User ID must be numeric.',
            'user_id.exists'       => 'Invalid User ID.',
            'image.required'       => 'Image is required.',
            'image.image'          => 'File must be an image.',
            'image.mimes'          => 'Allowed image types: jpeg, png, jpg, gif.',
            'image.max'            => 'Image size must not exceed 50MB.',
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
