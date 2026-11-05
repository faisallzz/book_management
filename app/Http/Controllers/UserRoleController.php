<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    // Daftar user beserta role-nya
    public function index()
    {
        return view('users.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::pluck('name'),
        ]);
    }

    // Mengubah role seorang user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Cegah admin menurunkan role dirinya sendiri (agar tidak terkunci)
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $user->syncRoles($data['role']);

        return back()->with('success', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}