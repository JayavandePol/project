<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Titel is verplicht.',
            'destination.required' => 'Bestemming is verplicht.',
            'description.required' => 'Beschrijving is verplicht.',
            'price.required' => 'Prijs is verplicht.',
            'price.numeric' => 'Prijs moet een getal zijn.',
            'max_participants.required' => 'Maximaal aantal deelnemers is verplicht.',
            'max_participants.integer' => 'Aantal deelnemers moet een geheel getal zijn.',
            'start_date.required' => 'Begindatum is verplicht.',
            'end_date.required' => 'Einddatum is verplicht.',
            'end_date.after' => 'Einddatum moet na de begindatum liggen.',
        ];
    }
}
