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

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:unpaid,paid,cancelled',
            ]);

            DB::statement("CALL UpdateFactuurStatus(?, ?)", [$id, $request->status]);

            return back()->with('success', 'Factuurstatus succesvol bijgewerkt via Stored Procedure.');
        } catch (\Exception $e) {
            Log::error('Fout bij het bijwerken van factuurstatus via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de factuurstatus.');
        }
    }
}
