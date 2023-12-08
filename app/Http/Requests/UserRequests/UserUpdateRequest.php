<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'password' => ['sometimes', 'required', 'min:6'],
            'role' => ['nullable']
        ];
    }
}
