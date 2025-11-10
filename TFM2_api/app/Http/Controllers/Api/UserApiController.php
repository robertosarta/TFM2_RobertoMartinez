<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="List all users (permission required)",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function index()
    {
        if (!Gate::allows('users-show')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $users = User::all();
        return $this->success($users);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new user (admin only)",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","role"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="role", type="string", enum={"admin","user"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request)
    {
        if (!Gate::allows('users-create')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,user'
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return $this->success($user, 'User created successfully', 201);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get a single user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->success($user, 200);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update a user (permission required)",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(@OA\JsonContent(
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="password", type="string"),
     *         @OA\Property(property="password_confirmation", type="string"),
     *         @OA\Property(property="phone", type="string"),
     *         @OA\Property(property="address", type="string"),
     *         @OA\Property(property="role", type="string", enum={"admin","user"})
     *     )),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     security={{"sanctum": {}}}
     * )
     */
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
            'role' => 'sometimes|in:admin,user',
        ]);

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $this->success($user, 'User updated successfully', 200);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user (permission required)",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy($id)
    {
        if (!Gate::allows('users-delete')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $user = User::findOrFail($id);
        $user->delete();
        return $this->success(null, 'User deleted successfully', 200);
    }
}
