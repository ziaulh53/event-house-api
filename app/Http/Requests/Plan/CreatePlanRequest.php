<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => [
                'required',
                'numeric', 
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'interval' => 'required|string',
            'interval_count' => 'required|integer',
            'max_service' => 'required|integer',
            'contact_hide' => 'required',
            'advertise' => 'required',
        ];
    }
}
