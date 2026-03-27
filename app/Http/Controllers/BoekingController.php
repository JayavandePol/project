<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use App\Models\Klant;
use App\Models\Reis;
use App\Models\Accommodatie;
use App\Http\Requests\StoreBoekingRequest;
use App\Http\Requests\UpdateBoekingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoekingController extends Controller
{
    /**
     * Toon een overzicht van alle boekingen.
     * Maakt gebruik van de GetAllBoekingen Stored Procedure voor een complete dataset inclusief joins.
     */
    public function index()
    {
        try {
            // Haal alle boekingen op via de database-laag (Stored Procedure)
            $boekingen = DB::select("CALL GetAllBoekingen()");
            return view('boekingen.index', compact('boekingen'));
        } catch (\Exception $e) {
            // Log de technische fout en toon een gebruiksvriendelijke melding
            Log::error('Fout bij het ophalen van boekingen via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de boekingen.');
        }
    }

    /**
     * Toon het formulier om een nieuwe boeking aan te maken.
     * Haalt noodzakelijke data (klanten, reizen, accommodaties) op via Stored Procedures.
     */
    public function create()
    {
        try {
            // Ophalen van referentiedata voor de dropdowns in de view
            $klanten = DB::select("CALL GetAllKlanten()");
            $reizen = DB::select("CALL GetAllReizen()");
            $accommodaties = DB::select("CALL GetAllAccommodaties()");
            return view('boekingen.create', compact('klanten', 'reizen', 'accommodaties'));
        } catch (\Exception $e) {
            // Log technische details voor debugging
            Log::error('Fout bij het ophalen van data voor boekingsformulier: ' . $e->getMessage());
            return redirect()->route('boekingen.index')->with('error', 'Kon formuliergegevens niet ophalen uit de database.');
        }
    }

    /**
     * Sla een nieuwe boeking op in de database.
     * De validatie wordt afgehandeld door de StoreBoekingRequest.
     * De database interactie gebeurt via een complexe Stored Procedure die ook facturen genereert.
     */
    public function store(StoreBoekingRequest $request)
    {
        try {
            // Roep de Stored Procedure aan die de boeking én de bijbehorende factuur aanmaakt
            DB::statement("CALL CreateBookingWithInvoice(?, ?, ?, ?, ?, ?, ?)", [
                Auth::id(),
                $request->klant_id,
                $request->reis_id,
                $request->accommodatie_id,
                $request->num_people,
                $request->booking_date,
                $request->status
            ]);
            return redirect()->route('boekingen.index')->with('success', 'Boeking en factuur succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            // In geval van een unhappy flow (bijv. database constraint violation)
            Log::error('Fout bij het maken van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het maken van de boeking.');
        }
    }

    /**
     * Toon het formulier om een bestaande boeking te bewerken.
     * Het resultaat bevat ook factuur- en reisdetails om te bepalen of de boeking 'locked' is.
     */
    public function edit($id)
    {
        try {
            // Haal de specifieke boeking op via SP
            $boekingResult = DB::select("CALL GetBoekingById(?)", [$id]);
            $boeking = $boekingResult[0] ?? abort(404);
            
            // Haal referentielijsten op voor de dropdowns
            $klanten = DB::select("CALL GetAllKlanten()");
            $reizen = DB::select("CALL GetAllReizen()");
            $accommodaties = DB::select("CALL GetAllAccommodaties()");

            // Strict MVC: Haal status-informatie op in de controller i.p.v. de view
            $invoice = DB::table('facturen')->where('boeking_id', $id)->first();
            $reis = DB::table('reizen')->where('id', $boeking->reis_id)->first();
            
            return view('boekingen.edit', compact('boeking', 'klanten', 'reizen', 'accommodaties', 'invoice', 'reis'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van boeking voor bewerken: ' . $e->getMessage());
            return redirect()->route('boekingen.index')->with('error', 'Boeking niet gevonden of kon niet worden geladen.');
        }
    }

    /**
     * Update de gegevens van een bestaande boeking.
     * Validatie gebeurt in UpdateBoekingRequest (inclusief business rules check).
     * De Stored Procedure UpdateBoeking controleert OOK op business logica op DB-niveau.
     */
    public function update(UpdateBoekingRequest $request, $id)
    {
        try {
            // Voer de update uit via de Stored Procedure
            DB::statement("CALL UpdateBoeking(?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->klant_id,
                $request->reis_id,
                $request->accommodatie_id,
                $request->num_people,
                $request->booking_date,
                $request->status
            ]);
            return redirect()->route('boekingen.index')->with('success', 'Boeking succesvol gewijzigd via Stored Procedure!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Specifieke afhandeling van business rule violations (SIGNAL 1644 uit de database)
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1644) {
                return back()->withInput()->with('error', $e->errorInfo[2]);
            }
            Log::error('Fout bij het wijzigen van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een databasefout opgetreden bij het wijzigen.');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van boeking via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }

    /**
     * Verwijder een boeking.
     * De Stored Procedure DeleteBoeking controleert of verwijdering toegestaan is (niet betaald, reis niet gestart).
     */
    public function destroy($id)
    {
        try {
            // Voer de verwijdering uit via de Stored Procedure
            DB::statement("CALL DeleteBoeking(?)", [$id]);
            return redirect()->route('boekingen.index')->with('success', 'Boeking succesvol verwijderd via Stored Procedure.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Robust error handling voor MySQL/MariaDB SIGNAL errors (1644)
            // Dit vangt business rules op die door de Stored Procedure worden gehandhaafd
            if ($e->getCode() == '45000' || str_contains($e->getMessage(), '1644')) {
                $errorMessage = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();
                // Strip de technische SQL prefix voor een schone foutmelding aan de gebruiker
                if (preg_match("/1644\s+(.*)/i", $errorMessage, $matches)) { $errorMessage = $matches[1]; }
                return back()->with('error', $errorMessage);
            }
            Log::error('Fout bij verwijderen van boeking (Database): ' . $e->getMessage());
            return back()->with('error', 'Systeemfout: Boeking kan niet worden verwijderd (mogelijk nog actieve koppelingen).');
        } catch (\Exception $e) {
            Log::error('Onverwachte fout bij verwijderen: ' . $e->getMessage());
            return back()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }
}
