<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;

class SubcategoryApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/subcategories",
     *     summary="List all subcategories",
     *     tags={"Subcategories"},
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
     *                 @OA\Items(ref="#/components/schemas/Subcategory")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return $this->success($subcategories, 200);
    }

    /**
     * @OA\Post(
     *     path="/subcategories",
     *     summary="Create a new subcategory (admin only)",
     *     tags={"Subcategories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","category_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="category_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subcategory created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/Subcategory")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory = Subcategory::create($validated);

        return $this->success($subcategory, 'Subcategory created successfully', 201);
    }

    /**
     * @OA\Get(
     *     path="/subcategories/{id}",
     *     summary="Get a single subcategory",
     *     tags={"Subcategories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Subcategory ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Subcategory not found")
     * )
     */
    public function show($id)
    {
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        return $this->success($subcategory, 200);
    }

    /**
     * @OA\Put(
     *     path="/subcategories/{id}",
     *     summary="Update a subcategory (admin only)",
     *     tags={"Subcategories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Subcategory ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="category_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Subcategory updated successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Subcategory not found"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $subcategory->update($validated);

        return $this->success($subcategory, 'Subcategory updated successfully', 200);
    }

    /**
     * @OA\Delete(
     *     path="/subcategories/{id}",
     *     summary="Delete a subcategory (admin only)",
     *     tags={"Subcategories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Subcategory ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Subcategory deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Subcategory not found"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        $subcategory->delete();

        return $this->success(null, 'Subcategory deleted successfully', 200);
    }
}
