<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('users-show')){
            abort(403);
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Gate::allows('users-create')) {
            abort(403);
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('users-create')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|regex:/^\+?[0-9]{9,15}$/', //ese regex vale para que admita numeros con '+' y minimo de 9 digitos, max 15
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,cliente'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success','201 Usuario creado correctamente');
    }

    public function destroy($id)
    {
        if (!Gate::allows('users-delete')){
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', '410 Usuario eliminado correctamente');
    }
}
