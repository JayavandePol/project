<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccommodatieRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string|in:Hotel,B&B,Camping,Appartement',
            'price_per_night' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'location.required' => 'Locatie is verplicht.',
            'type.required' => 'Type is verplicht.',
            'price_per_night.required' => 'Prijs per nacht is verplicht.',
            'price_per_night.numeric' => 'Prijs moet een getal zijn.',
        ];
    }
}
