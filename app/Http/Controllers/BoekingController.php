<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use App\Models\Klant;
use App\Models\Reis;
use App\Models\Accommodatie;
use App\Http\Requests\StoreBoekingRequest;
use App\Http\Requests\UpdateBoekingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoekingController extends Controller
{
    public function index()
    {
        try {
            $boekingen = DB::select("CALL GetAllBoekingen()");
            return view('boekingen.index', compact('boekingen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van boekingen via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de boekingen.');
        }
    }

    public function create()
    {
        try {
            $klanten = DB::select("CALL GetAllKlanten()");
            $reizen = DB::select("CALL GetAllReizen()");
            $accommodaties = DB::select("CALL GetAllAccommodaties()");
            return view('boekingen.create', compact('klanten', 'reizen', 'accommodaties'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van data voor boekingsformulier: ' . $e->getMessage());
            return redirect()->route('boekingen.index')->with('error', 'Kon formuliergegevens niet ophalen.');
        }
    }

    public function store(StoreBoekingRequest $request)
    {
        try {
            DB::statement("CALL CreateBookingWithInvoice(?, ?, ?, ?, ?, ?, ?)", [
                Auth::id(),
                $request->klant_id,
                $request->reis_id,
                $request->accommodatie_id,
                $request->num_people,
                $request->booking_date,
                $request->status
            ]);
            return redirect()->route('boekingen.index')->with('success', 'Boeking en factuur succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het maken van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het maken van de boeking.');
        }
    }

    public function edit($id)
    {
        try {
            $boekingResult = DB::select("CALL GetBoekingById(?)", [$id]);
            $boeking = $boekingResult[0] ?? abort(404);
            
            $klanten = DB::select("CALL GetAllKlanten()");
            $reizen = DB::select("CALL GetAllReizen()");
            $accommodaties = DB::select("CALL GetAllAccommodaties()");
            
            return view('boekingen.edit', compact('boeking', 'klanten', 'reizen', 'accommodaties'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van boeking voor bewerken: ' . $e->getMessage());
            return redirect()->route('boekingen.index')->with('error', 'Boeking niet gevonden.');
        }
    }

    public function update(UpdateBoekingRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateBoeking(?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->klant_id,
                $request->reis_id,
                $request->accommodatie_id,
                $request->num_people,
                $request->booking_date,
                $request->status
            ]);
            return redirect()->route('boekingen.index')->with('success', 'Boeking succesvol gewijzigd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het wijzigen van de boeking.');
        }
    }
}
