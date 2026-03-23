<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Http\Requests\StoreKlantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KlantController extends Controller
{
    public function index()
    {
        try {
            $klanten = DB::select("CALL GetAllKlanten()");
            return view('klanten.index', compact('klanten'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van klanten via SP: ' . $e->getMessage());
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
            DB::statement("CALL InsertKlant(?, ?, ?, ?)", [
                $request->name,
                $request->email,
                $request->phone,
                $request->address
            ]);
            return redirect()->route('klanten.index')->with('success', 'Klant succesvol toegevoegd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van klant via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de klant.');
        }
    }
}
