<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'content' => [
                'required_without_all:images,videos',
            ],
            'images' => [
                'array',
                'required_without_all:content,videos',
            ],
            'images.*' => [
                'file',
                'image',
                'max:' . config('constants.validation.max_image_size'),
            ],
            'videos' => [
                'array',
                'required_without_all:content,images',
            ],
            'videos.*' => [
                'file',
                'max:' . config('constants.validation.max_video_size'),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.*.max' => __('validation.custom.image.max', [
                'max' => config('constants.validation.max_image_size'),
            ]),
        ];
    }
}
