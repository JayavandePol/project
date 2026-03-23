<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $statsResult = DB::select("CALL GetDashboardStats()");
            $stats = $statsResult[0] ?? (object)[
                'total_users' => 0,
                'total_bookings' => 0,
                'total_trips' => 0,
                'total_revenue' => 0
            ];
            
            return view('dashboard', compact('stats'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van dashboard stats via SP: ' . $e->getMessage());
            return view('dashboard', [
                'stats' => (object)[
                    'total_users' => 0,
                    'total_bookings' => 0,
                    'total_trips' => 0,
                    'total_revenue' => 0
                ]
            ]);
        }
    }
}
