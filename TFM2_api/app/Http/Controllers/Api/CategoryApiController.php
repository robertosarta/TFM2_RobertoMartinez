<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="List all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Category")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $categories = Category::all();
        return $this->success($categories, 200);
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category (admin only)",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/Category")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request) 
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create($validated);

        return $this->success($category, 'Category created successfully', 201);
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update a category (admin only)",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Category ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/Category")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category = Category::find($id);
        if (!$category) {
            return $this->error('Category not found', 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $category->update($validated);
        
        return $this->success($category, 'Category updated successfully', 200);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete a category(admin only)",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Category ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $category = Category::find($id);
        if (!$category) {
            return $this->error('Category not found', 404);
        }
        $category->delete();

        return $this->success(null, 'Category deleted successfully', 200);
    }
}
