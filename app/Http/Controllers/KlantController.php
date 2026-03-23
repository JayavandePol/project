<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Http\Requests\StoreKlantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KlantController extends Controller
{
    public function index()
    {
        try {
            $klanten = Klant::all();
            return view('klanten.index', compact('klanten'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van klanten: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de klanten.');
        }
    }

    public function create()
    {
        return view('klanten.create');
    }

    public function store(StoreKlantRequest $request)
    {
        try {
            Klant::create($request->validated());
            return redirect()->route('klanten.index')->with('success', 'Klant succesvol toegevoegd!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van klant: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de klant.');
        }
    }
}
