<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function index()
    {
        if (!Gate::allows('users-show')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,cliente'
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json(['data' => $user], 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('users-update')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'role' => 'sometimes|in:admin,cliente',
        ]);

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return response()->json(['data' => $user], 200);
    }

    public function destroy($id)
    {
        if (!Gate::allows('users-delete')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}