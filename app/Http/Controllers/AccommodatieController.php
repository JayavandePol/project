<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
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
}
