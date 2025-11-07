<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/services",
     *     summary="List all services",
     *     tags={"Services"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Service"))
     *     )
     * )
     */
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * @OA\Post(
     *     path="/services",
     *     summary="Create a new service",
     *     tags={"Services"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="address", type="object"),
     *             @OA\Property(property="address.street", type="string"),
     *             @OA\Property(property="address.city", type="string"),
     *             @OA\Property(property="address.zip", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="string"),
     *             @OA\Property(property="subcategory_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Service created successfully"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|array|max:255',
            'adress.street' => 'nullable|string|max:255',
            'adress.city' => 'nullable|string|max:255',
            'adress.zip' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'subcategory_id' => 'nullable|integer|exists:subcategories,id'
        ]);

        $service = Service::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'subcategory_id' => $request->subcategory_id
        ]);
        return response()->json($service, 201);
    }

    /**
     * @OA\Get(
     *     path="/services/{id}",
     *     summary="Get a single service",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Service ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found")
     * )
     */
    public function show(string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        return response()->json($service);
    }

    /**
     * @OA\Put(
     *     path="/services/{id}",
     *     summary="Update a service",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Service ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="address", type="object"),
     *             @OA\Property(property="address.street", type="string"),
     *             @OA\Property(property="address.city", type="string"),
     *             @OA\Property(property="address.zip", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="string"),
     *             @OA\Property(property="subcategory_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Service updated successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Service not found"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if(!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $user = Auth::user();
        if ($service->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'address.street' => 'sometimes|string|max:255',
            'address.city' => 'sometimes|string|max:255',
            'address.zip' => 'sometimes|string|max:20',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'subcategory_id' => 'sometimes|integer|exists:subcategories,id'
        ]);

        $service->update($request->only([
            'name',
            'email',
            'phone',
            'address',
            'description',
            'price',
            'subcategory_id'
        ]));
        
        return response()->json($service);
    }

    /**
     * @OA\Delete(
     *     path="/services/{id}",
     *     summary="Delete a service",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Service ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Service deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=404, description="Service not found"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if(!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $user = Auth::user();

        if($service->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $service->delete();
        return response()->json(['message' => 'Service deleted']);
    }
}