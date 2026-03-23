<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoekingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'klant_id' => 'required|exists:klanten,id',
            'reis_id' => 'required|exists:reizen,id',
            'accommodatie_id' => 'required|exists:accommodaties,id',
            'num_people' => 'required|integer|min:1',
            'booking_date' => 'required|date',
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'klant_id.required' => 'Selecteer een klant.',
            'klant_id.exists' => 'Geselecteerde klant bestaat niet.',
            'reis_id.required' => 'Selecteer een reis.',
            'reis_id.exists' => 'Geselecteerde reis bestaat niet.',
            'accommodatie_id.required' => 'Selecteer een accommodatie.',
            'accommodatie_id.exists' => 'Geselecteerde accommodatie bestaat niet.',
            'num_people.required' => 'Aantal personen is verplicht.',
            'num_people.integer' => 'Aantal personen moet een geheel getal zijn.',
            'num_people.min' => 'Aantal personen moet minimaal 1 zijn.',
            'booking_date.required' => 'Boekingsdatum is verplicht.',
            'status.required' => 'Status is verplicht.',
        ];
    }
}
