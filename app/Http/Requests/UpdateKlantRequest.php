<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKlantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:klanten,email,' . $this->route('id'),
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'postal_code' => ['required', 'string', 'regex:/^[0-9]{4}\s?[A-Z]{2}$/i'],
            'city' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'email.required' => 'E-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'address.required' => 'Adres is verplicht.',
            'postal_code.required' => 'Postcode is verplicht.',
            'postal_code.regex' => 'Voer een geldige Nederlandse postcode in (bijv. 1234 AB).',
            'city.required' => 'Stad is verplicht.',
        ];
    }
}
