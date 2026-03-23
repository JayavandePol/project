<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
