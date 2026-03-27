<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateFactuurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid,cancelled',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id');
            $factuur = DB::table('facturen')->where('id', $id)->first();

            if ($factuur && $factuur->status === 'paid') {
                $validator->errors()->add('status', 'Deze factuur is al betaald en kan niet meer gewijzigd worden.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Bedrag is verplicht.',
            'due_date.required' => 'Vervaldatum is verplicht.',
            'status.required' => 'Status is verplicht.',
        ];
    }
}
