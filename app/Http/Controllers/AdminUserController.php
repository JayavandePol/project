<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class AdminUserController extends Controller
{
    public function index()
    {
        try {
            $users = DB::select("CALL GetAllUsers()");
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van gebruikers via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het laden van de gebruikers.');
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::statement("CALL InsertUser(?, ?, ?, ?)", [
                $request->name,
                $request->email,
                Hash::make($request->password),
                $request->role,
            ]);
            
            return redirect()->route('admin.users.index')->with('success', 'Nieuw account succesvol aangemaakt via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het aanmaken van account via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het aanmaken van het account.');
        }
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:admin,user',
        ]);

        try {
            DB::unprepared('CALL update_user_role(' . $user->id . ', \'' . $request->role . '\')');
            return back()->with('success', 'User role updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update user role: ' . $e->getMessage());
        }
    }
}
