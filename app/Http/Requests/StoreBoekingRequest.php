<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBoekingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'klant_id' => 'required|exists:klanten,id',
            'reis_id' => 'required|exists:reizen,id',
            'accommodatie_id' => 'required|exists:accommodaties,id',
            'booking_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'klant_id.required' => 'Selecteer een klant.',
            'reis_id.required' => 'Selecteer een reis.',
            'accommodatie_id.required' => 'Selecteer een accommodatie.',
            'booking_date.required' => 'Boekingsdatum is verplicht.',
        ];
    }
}
