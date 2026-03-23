<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function edit($id)
    {
        try {
            $userResult = DB::select("CALL GetUserById(?)", [$id]);
            $user = $userResult[0] ?? abort(404);
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Fout bij het ophalen van user voor bewerken: ' . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error', 'User niet gevonden.');
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            DB::statement("CALL UpdateUser(?, ?, ?, ?)", [
                $id,
                $request->name,
                $request->email,
                $request->role
            ]);
            return redirect()->route('admin.users.index')->with('success', 'User succesvol gewijzigd via Stored Procedure!');
        } catch (\Exception $e) {
            Log::error('Fout bij het wijzigen van user via SP: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Er is een fout opgetreden bij het wijzigen van de user.');
        }
    }

    public function updateRole(Request $request, $id)
    {
        try {
            $request->validate([
                'role' => 'required|in:admin,user',
            ]);

            // We use UpdateUser but only changing the role. The SP requires ID, Name, Email, Role.
            // We need to fetch the user first to get their existing name and email.
            $userResult = DB::select("CALL GetUserById(?)", [$id]);
            $user = $userResult[0] ?? abort(404);

            DB::statement("CALL UpdateUser(?, ?, ?, ?)", [
                $id,
                $user->name,
                $user->email,
                $request->role
            ]);

            return back()->with('success', 'Gebruikersrol succesvol bijgewerkt via Stored Procedure.');
        } catch (\Exception $e) {
            Log::error('Fout bij het bijwerken van gebruikersrol via SP: ' . $e->getMessage());
            return back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de gebruikersrol.');
        }
    }
}
