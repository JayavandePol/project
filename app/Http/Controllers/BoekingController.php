<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use App\Models\Klant;
use App\Models\Reis;
use App\Models\Accommodatie;
use App\Http\Requests\StoreBoekingRequest;
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
        $klanten = Klant::all();
        $reizen = Reis::all();
        $accommodaties = Accommodatie::all();
        return view('boekingen.create', compact('klanten', 'reizen', 'accommodaties'));
    }

    public function store(StoreBoekingRequest $request)
    {
        try {
            DB::statement("CALL CreateBookingWithInvoice(?, ?, ?, ?, ?, ?)", [
                Auth::id(),
                $request->klant_id,
                $request->reis_id,
                $request->accommodatie_id,
                $request->booking_date,
                $request->status
            ]);

            return redirect()->route('boekingen.index')->with('success', 'Boeking en factuur succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de boeking.');
        }
    }
}
