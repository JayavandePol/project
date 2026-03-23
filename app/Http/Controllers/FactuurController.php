<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FactuurController extends Controller
{
    public function index()
    {
        try {
            $facturen = Factuur::with('boeking.klant')->get();
            return view('facturen.index', compact('facturen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van facturen: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de facturen.');
        }
    }
}
