<?php

namespace App\Http\Requests\ControlAccess;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestControllAccessRequest extends FormRequest
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
            'visitor_id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'destination_person' => ['required'],
            'visit_members' => ['nullable'],
            'date' => ['required'],
            'date_out' => ['required'],
        ];
    }
}
