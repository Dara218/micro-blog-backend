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
                'required_without_all:content,videos',
                'image',
                'mimes:png,jpg,jpeg,gif',
            ],
            'videos' => [
                'required_without_all:content,images',
                'mimes:mp4,mov,ogg,webm',
                'max:' . config('constants.validation.max_video_size'),
            ],
        ];
    }
}
