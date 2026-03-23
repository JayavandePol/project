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

class BoekingController extends Controller
{
    public function index()
    {
        try {
            // Eager load relationships for the overview
            $boekingen = Boeking::with(['klant', 'reis', 'accommodatie', 'user'])->get();
            return view('boekingen.index', compact('boekingen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van boekingen: ' . $e->getMessage());
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
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            
            Boeking::create($data);
            return redirect()->route('boekingen.index')->with('success', 'Boeking succesvol aangemaakt!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van boeking: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de boeking.');
        }
    }
}
