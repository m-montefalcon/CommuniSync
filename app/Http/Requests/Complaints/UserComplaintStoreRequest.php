<?php

namespace App\Http\Requests\Complaints;

use Illuminate\Foundation\Http\FormRequest;

class UserComplaintStoreRequest extends FormRequest
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
            'homeowner_id' => ['required'],
            'complaint_title' => ['required'],
            'complaint_desc' => ['required'],
            'complaint_photo' => ['nullable']
        ];
    }
}
