<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserAuthStoreRequest extends FormRequest
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
            'user_name' => ['required', 'min:6', Rule::unique('users', 'user_name')],
            'email' => ['required', 'min:4',   'email'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'], 
            'photo' => ['image', 'nullable'],
            'password' => ['required', 'min:6'],
            'role' => ['required']
        ];
    }
}
