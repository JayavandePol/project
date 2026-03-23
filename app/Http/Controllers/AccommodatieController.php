<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
use App\Http\Requests\StoreAccommodatieRequest;
use App\Http\Requests\UpdateAccommodatieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AccommodatieController extends Controller
{
    public function index()
    {
        try {
            $accommodaties = DB::select("CALL GetAllAccommodaties()");
            return view('accommodaties.index', compact('accommodaties'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van accommodaties via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de accommodaties.');
        }
    }

    public function create()
    {
        return view('accommodaties.create');
    }

    public function store(StoreAccommodatieRequest $request)
    {
        try {
            DB::statement("CALL InsertAccommodatie(?, ?, ?, ?, ?, ?)", [
                $request->name,
                $request->location,
                $request->type,
                $request->rating,
                $request->amenities,
                $request->price_per_night
            ]);
            return redirect()->route('accommodaties.index')->with('success', 'Accommodatie succesvol toegevoegd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van accommodatie via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de accommodatie.');
        }
    }

    public function edit($id)
    {
        try {
            $accommodatieResult = DB::select("CALL GetAccommodatieById(?)", [$id]);
            $accommodatie = $accommodatieResult[0] ?? abort(404);
            return view('accommodaties.edit', compact('accommodatie'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van accommodatie voor bewerken: ' . $e->getMessage());
            return redirect()->route('accommodaties.index')->with('error', 'Accommodatie niet gevonden.');
        }
    }

    public function update(UpdateAccommodatieRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateAccommodatie(?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->name,
                $request->location,
                $request->type,
                $request->rating,
                $request->amenities,
                $request->price_per_night
            ]);
            return redirect()->route('accommodaties.index')->with('success', 'Accommodatie succesvol gewijzigd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van accommodatie via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het wijzigen van de accommodatie.');
        }
    }
}
