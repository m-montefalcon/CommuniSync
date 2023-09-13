<?php

namespace App\Http\Requests\BlockLists;

use Illuminate\Foundation\Http\FormRequest;

class UserValidatedBlockListRequest extends FormRequest
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
            'admin_id' => ['required', 'numeric'],
            'blocked_status_response_description'=> ['nullable'],
        ];
    }
}
