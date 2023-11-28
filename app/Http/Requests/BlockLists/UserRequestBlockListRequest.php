<?php

namespace App\Http\Requests\BlockLists;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestBlockListRequest extends FormRequest
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
        return [
            'homeowner_id'     => ['required', 'numeric'],
            'first_name'       => ['required'],
            'last_name'        => ['required'],
            'contact_number'   => ['nullable'],
            'blocked_reason'   => ['required'],
        ];
    }
}
