<?php

namespace App\Http\Controllers;

use App\Models\Reis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReisController extends Controller
{
    public function index()
    {
        try {
            $reizen = Reis::all();
            return view('reizen.index', compact('reizen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van reizen: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de reizen.');
        }
    }
}
