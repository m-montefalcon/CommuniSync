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
            'email' => ['required', 'min:4',],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'], 
            'photo' => ['image', 'nullable'],
            'password' => ['required', 'min:6'],
            'block_no' => ['nullable'],
            'lot_no' => ['nullable'],
            'manual_visit_option' => ['nullable'],
            'family_member' => ['nullable'],
            'role' => ['required']
            
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'The username field is required.',
            'user_name.min' => 'The username must be at least 6 characters long.',
            'user_name.unique' => 'The username has already been taken.',
            
            'email.required' => 'The email field is required.',
            'email.min' => 'The email must be at least 4 characters long.',
            
            'first_name.required' => 'The first name field is required.',
            
            'last_name.required' => 'The last name field is required.',
            
            'contact_number.required' => 'The contact number field is required.',
            
            'photo.image' => 'The photo must be an image.',
            
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters long.',
            
            'role.required' => 'The role field is required.'
        ];
    }
}
