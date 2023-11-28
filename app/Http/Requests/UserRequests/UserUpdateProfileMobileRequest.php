<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileMobileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('id'); // Get the 'id' parameter from the route

        return [
            'user_name' => ['required', 'min:6', Rule::unique('users', 'user_name')->ignore($id)],
            'email' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'contact_number' => ['required'],
            'manual_visit_option' => ['nullable'],
            'photo' => ['nullable'],
            'block_no' => 'nullable',
            'lot_no' => 'nullable',
            'family_member' => ['nullable'],
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
