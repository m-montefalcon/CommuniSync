<?php

namespace App\Http\Requests\PaymentRecords;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserPaymentRequest extends FormRequest
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
            'transaction_number' => ['required', Rule::unique('payment_records', 'transaction_number')],
            'notes' => ['nullable'],
            'payment_amount' => ['required'],
        ];
    }
}
