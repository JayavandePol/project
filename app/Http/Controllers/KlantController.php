<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Http\Requests\StoreKlantRequest;
use App\Http\Requests\UpdateKlantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KlantController extends Controller
{
    public function index()
    {
        try {
            $klanten = DB::select("CALL GetAllKlanten()");
            return view('klanten.index', compact('klanten'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van klanten via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de klanten.');
        }
    }

    public function create()
    {
        return view('klanten.create');
    }

    public function store(StoreKlantRequest $request)
    {
        try {
            DB::statement("CALL InsertKlant(?, ?, ?, ?, ?, ?)", [
                $request->name,
                $request->email,
                $request->phone,
                $request->address,
                $request->postal_code,
                $request->city
            ]);
            return redirect()->route('klanten.index')->with('success', 'Klant succesvol toegevoegd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van klant via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de klant.');
        }
    }

    public function edit($id)
    {
        try {
            $klantResult = DB::select("CALL GetKlantById(?)", [$id]);
            $klant = $klantResult[0] ?? abort(404);
            return view('klanten.edit', compact('klant'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van klant voor bewerken: ' . $e->getMessage());
            return redirect()->route('klanten.index')->with('error', 'Klant niet gevonden.');
        }
    }

    public function update(UpdateKlantRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateKlant(?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->name,
                $request->email,
                $request->phone,
                $request->address,
                $request->postal_code,
                $request->city
            ]);
            return redirect()->route('klanten.index')->with('success', 'Klant succesvol gewijzigd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van klant via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het wijzigen van de klant.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::statement("CALL DeleteKlant(?)", [$id]);
            return redirect()->route('klanten.index')->with('success', 'Klant succesvol verwijderd via Stored Procedure.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '45000' || str_contains($e->getMessage(), '1644')) {
                $errorMessage = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
                if (preg_match("/1644\s+(.*)/i", $errorMessage, $matches)) { $errorMessage = $matches[1]; }
                return back()->with('error', $errorMessage);
            }
            Log::error('Databasefout bij verwijderen klant: ' . $e->getMessage());
            return back()->with('error', 'Systeemfout: Klant kan niet worden verwijderd (mogelijk nog actieve koppelingen).');
        } catch (\Exception $e) {
            Log::error('Fout bij verwijderen van klant: ' . $e->getMessage());
            return back()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }
}
