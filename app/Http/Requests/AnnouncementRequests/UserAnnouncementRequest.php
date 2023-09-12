<?php

namespace App\Http\Requests\AnnouncementRequests;

use Illuminate\Foundation\Http\FormRequest;

class UserAnnouncementRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'announcement_title' => 'required',
            'announcement_description' => 'required',
            'announcement_photo' => ['nullable'],
            'role' => 'required|array'
        ];
    }
}
