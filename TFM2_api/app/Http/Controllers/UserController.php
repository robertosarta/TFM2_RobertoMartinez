<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('ver-usuarios')){
            abort(403);
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function destroy($id)
    {
        if (!Gate::allows('eliminar-usuarios')){
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')->with('success', '410 Usuario eliminado correctamente');
    }
}
