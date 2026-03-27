<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FactuurController extends Controller
{
    public function index()
    {
        try {
            $facturen = DB::select("CALL GetAllFacturen()");
            return view('facturen.index', compact('facturen'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van facturen via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de facturen.');
        }
    }

    public function create()
    {
        try {
            $boekingen = DB::select("CALL GetAllBoekingen()");
            return view('facturen.create', compact('boekingen'));
        } catch (\Exception $e) {
            Log::error('Fout bij laden create formulier factuur: ' . $e->getMessage());
            return redirect()->route('facturen.index')->with('error', 'Kon boekingen niet laden.');
        }
    }

    public function store(\App\Http\Requests\StoreFactuurRequest $request)
    {
        try {
            DB::statement("CALL InsertFactuur(?, ?, ?, ?)", [
                $request->boeking_id,
                $request->amount,
                $request->due_date,
                $request->status
            ]);
            return redirect()->route('facturen.index')->with('success', 'Factuur succesvol aangemaakt met UUID.');
        } catch (\Exception $e) {
            Log::error('Fout bij opslaan factuur via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het aanmaken van de factuur.');
        }
    }

    public function edit($id)
    {
        try {
            $factuurResult = DB::select("CALL GetFactuurById(?)", [$id]);
            $factuur = $factuurResult[0] ?? abort(404);
            return view('facturen.edit', compact('factuur'));
        } catch (\Exception $e) {
            Log::error('Fout bij laden edit formulier factuur: ' . $e->getMessage());
            return redirect()->route('facturen.index')->with('error', 'Factuur niet gevonden.');
        }
    }

    public function update(\App\Http\Requests\UpdateFactuurRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateFactuur(?, ?, ?, ?)", [
                $id,
                $request->amount,
                $request->due_date,
                $request->status
            ]);
            return redirect()->route('facturen.index')->with('success', 'Factuur succesvol bijgewerkt.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '45000' || str_contains($e->getMessage(), '1644')) {
                $errorMessage = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
                if (preg_match("/1644\s+(.*)/i", $errorMessage, $matches)) { $errorMessage = $matches[1]; }
                return back()->withInput()->with('error', $errorMessage);
            }
            Log::error('Databasefout bij updaten factuur: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een databasefout opgetreden.');
        } catch (\Exception $e) {
            Log::error('Fout bij updaten factuur via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::statement("CALL DeleteFactuur(?)", [$id]);
            return redirect()->route('facturen.index')->with('success', 'Factuur succesvol verwijderd via Stored Procedure.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '45000' || str_contains($e->getMessage(), '1644')) {
                $errorMessage = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
                if (preg_match("/1644\s+(.*)/i", $errorMessage, $matches)) { $errorMessage = $matches[1]; }
                return back()->with('error', $errorMessage);
            }
            Log::error('Fout bij verwijderen factuur (Database): ' . $e->getMessage());
            return back()->with('error', 'Systeemfout: Factuur kan niet worden verwijderd.');
        } catch (\Exception $e) {
            Log::error('Onverwachte fout bij verwijderen factuur: ' . $e->getMessage());
            return back()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }
}
