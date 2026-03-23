<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccommodatieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:Hotel,Appartement,Resort,Camping,Anders',
            'rating' => 'required|integer|min:1|max:5',
            'amenities' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'location.required' => 'Locatie is verplicht.',
            'type.required' => 'Type is verplicht.',
            'rating.required' => 'Rating is verplicht.',
            'rating.integer' => 'Rating moet een geheel getal zijn.',
            'rating.min' => 'Rating moet minimaal 1 ster zijn.',
            'rating.max' => 'Rating mag maximaal 5 sterren zijn.',
            'price_per_night.required' => 'Prijs per nacht is verplicht.',
            'price_per_night.numeric' => 'Prijs per nacht moet een getal zijn.',
        ];
    }
}
