<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
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
