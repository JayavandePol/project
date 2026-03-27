<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoekingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * De regels waaraan een nieuwe boeking moet voldoen.
     */
    public function rules(): array
    {
        return [
            'klant_id' => 'required|exists:klanten,id', // Klant moet bestaan
            'reis_id' => 'required|exists:reizen,id',   // Reis moet bestaan
            'accommodatie_id' => 'required|exists:accommodaties,id', // Accommodatie moet bestaan
            'num_people' => 'required|integer|min:1',  // Minimaal 1 persoon
            'booking_date' => 'required|date|after_or_equal:today', // Geen boekingen in het verleden
            'status' => 'required|string|in:pending,confirmed,cancelled', // Vaste statussen
        ];
    }

    /**
     * Aangepaste foutmeldingen voor de gebruiker.
     */
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
