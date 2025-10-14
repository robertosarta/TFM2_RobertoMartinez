<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada correctamente',
            'data' => $category
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $category->update([
            'name' => $request->name
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'categoria actualizada correctamente',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoria eliminada correctamente'
        ]);
    }
}