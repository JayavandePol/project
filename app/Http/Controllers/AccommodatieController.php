<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
use App\Http\Requests\StoreAccommodatieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccommodatieController extends Controller
{
    public function index()
    {
        try {
            $accommodaties = Accommodatie::all();
            return view('accommodaties.index', compact('accommodaties'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van accommodaties: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de accommodaties.');
        }
    }

    public function create()
    {
        return view('accommodaties.create');
    }

    public function store(StoreAccommodatieRequest $request)
    {
        try {
            Accommodatie::create($request->validated());
            return redirect()->route('accommodaties.index')->with('success', 'Accommodatie succesvol toegevoegd!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van accommodatie: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de accommodatie.');
        }
    }
}
