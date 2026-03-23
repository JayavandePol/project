<?php

namespace App\Http\Controllers;

use App\Models\Reis;
use App\Http\Requests\StoreReisRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReisController extends Controller
{
    public function index()
    {
        try {
            $reizen = DB::select("CALL GetAllReizen()");
            return view('reizen.index', compact('reizen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van reizen via SP: ' . $e->getMessage());
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
            DB::statement("CALL InsertReis(?, ?, ?, ?, ?)", [
                $request->title,
                $request->description,
                $request->price,
                $request->start_date,
                $request->end_date
            ]);
            return redirect()->route('reizen.index')->with('success', 'Reis succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van reis via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de reis.');
        }
    }
}
