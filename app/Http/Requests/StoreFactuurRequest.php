<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactuurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'boeking_id' => 'required|exists:boekingen,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'boeking_id.required' => 'Selecteer een boeking.',
            'amount.required' => 'Bedrag is verplicht.',
            'due_date.required' => 'Vervaldatum is verplicht.',
            'status.required' => 'Status is verplicht.',
        ];
    }
}
