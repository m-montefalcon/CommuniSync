<?php

namespace App\Http\Requests\ControlAccess;

use Illuminate\Foundation\Http\FormRequest;

class SpCheckIdRequest extends FormRequest
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
            'id' => ['required', 'integer'],
            'homeowner_id' => ['required', 'integer'],
            'visitor_id' => ['required', 'integer'],

        ];
    }
}
