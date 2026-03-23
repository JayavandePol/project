<?php

namespace App\Http\Controllers;

use App\Models\Reis;
use App\Http\Requests\StoreReisRequest;
use App\Http\Requests\UpdateReisRequest;
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
            DB::statement("CALL InsertReis(?, ?, ?, ?, ?, ?, ?)", [
                $request->title,
                $request->destination,
                $request->description,
                $request->price,
                $request->max_participants,
                $request->start_date,
                $request->end_date
            ]);
            return redirect()->route('reizen.index')->with('success', 'Reis succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het opslaan van reis via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het opslaan van de reis.');
        }
    }

    public function edit($id)
    {
        try {
            $reisResult = DB::select("CALL GetReisById(?)", [$id]);
            $reis = $reisResult[0] ?? abort(404);
            return view('reizen.edit', compact('reis'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van reis voor bewerken: ' . $e->getMessage());
            return redirect()->route('reizen.index')->with('error', 'Reis niet gevonden.');
        }
    }

    public function update(UpdateReisRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateReis(?, ?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->title,
                $request->destination,
                $request->description,
                $request->price,
                $request->max_participants,
                $request->start_date,
                $request->end_date
            ]);
            return redirect()->route('reizen.index')->with('success', 'Reis succesvol gewijzigd via Stored Procedure!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1644) {
                return back()->withInput()->with('error', $e->errorInfo[2]);
            }
            Log::error('Fout bij het wijzigen van reis via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een databasefout opgetreden bij het wijzigen van de reis.');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van reis via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::statement("CALL DeleteReis(?)", [$id]);
            return redirect()->route('reizen.index')->with('success', 'Reis succesvol verwijderd via Stored Procedure.');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1644) {
                return back()->with('error', $e->errorInfo[2]);
            }
            Log::error('Fout bij verwijderen van reis: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het verwijderen.');
        } catch (\Exception $e) {
            Log::error('Onverwachte fout bij verwijderen: ' . $e->getMessage());
            return back()->with('error', 'Er is een onverwachte fout opgetreden.');
        }
    }
}
