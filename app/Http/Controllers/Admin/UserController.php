<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.index', [
            'users' => User::with('roles')->orderBy('name')->paginate(15),
            'roles' => Role::orderBy('name')->pluck('name'),
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => ['required', Rule::in(Role::pluck('name')->all())]]);

        abort_if($user->id === $request->user()->id, 422, __('Tidak dapat mengubah role akun sendiri.'));

        $user->syncRoles($request->role);

        return back()->with('success', __('Role :nama diubah menjadi :role.', ['nama' => $user->name, 'role' => $request->role]));
    }
}
