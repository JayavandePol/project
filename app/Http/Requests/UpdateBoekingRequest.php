<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id');
            
            $boekingResult = DB::select("CALL GetBoekingById(?)", [$id]);
            $boeking = $boekingResult[0] ?? null;
            
            if (!$boeking) return;

            // Check invoice status
            $invoice = DB::table('facturen')->where('boeking_id', $id)->first();
            if ($invoice && $invoice->status === 'paid') {
                $validator->errors()->add('status', 'Deze boeking is al betaald en kan niet meer gewijzigd worden.');
            }

            // Check travel start date
            $reisResult = DB::select("CALL GetReisById(?)", [$boeking->reis_id]);
            $reis = $reisResult[0] ?? null;
            if ($reis && Carbon::parse($reis->start_date)->isPast()) {
                $validator->errors()->add('status', 'De reis voor deze boeking is al gestart of voltooid.');
            }
        });
    }
}
