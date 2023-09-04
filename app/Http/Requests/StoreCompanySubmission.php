<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanySubmission extends FormRequest
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
            'company_symbol' => 'required|exists:company_listings,Symbol',
            'start_date' => 'required|date_format:Y-m-d|before_or_equal:end_date|before_or_equal:today',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date|after_or_equal:today',
            'email' => 'required|email:rfc,dns',
        ];
    }
}
