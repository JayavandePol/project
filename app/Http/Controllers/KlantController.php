<?php

namespace App\Http\Controllers;

use App\Models\Klant;
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
}
