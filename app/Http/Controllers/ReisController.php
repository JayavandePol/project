<?php

namespace App\Http\Controllers;

use App\Models\Reis;
use App\Http\Requests\StoreReisRequest;
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

    public function create()
    {
        return view('reizen.create');
    }

    public function store(StoreReisRequest $request)
    {
        try {
            Reis::create($request->validated());
            return redirect()->route('reizen.index')->with('success', 'Reis succesvol aangemaakt!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van reis: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de reis.');
        }
    }
}
