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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ServiceBasic")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $services = Service::all();
        return $this->success($services, 200);
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
     *             @OA\Property(
     *                 property="address",
     *                 type="object",
     *                 @OA\Property(property="street", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="zip", type="string"),
     *             ),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="string"),
     *             @OA\Property(property="subcategory_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Service created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/ServiceBasic")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object", example={
     *                 "name": {"The name field is required."},
     *                 "price": {"The price field must be a number."}
     *             })
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|array',
            'address.street' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.zip' => 'nullable|string|max:20',
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
        return $this->success($service, 'Service created successfully', 201);
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/ServiceBasic")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Service not found")
     *         )
     *     )
     * )
     */
    public function show(int $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return $this->error('Service not found', 404);
        }
        return $this->success($service, 200);
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
     *             @OA\Property(
     *                 property="address",
     *                 type="object",
     *                 @OA\Property(property="street", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="zip", type="string"),
     *             ),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="string"),
     *             @OA\Property(property="subcategory_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", ref="#/components/schemas/ServiceBasic")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed or empty payload",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No data provided or invalid JSON"),
     *             @OA\Property(property="errors", type="object", nullable=true, example={"name": {"The name field must be a string."}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Service not found"),
     *     security={{"sanctum": {}}}
     * )
     */
    public function update(Request $request, int $id)
    {
        $service = Service::find($id);

        if(!$service) {
            return $this->error('Service not found', 404);
        }

        $user = Auth::user();
        if ($service->user_id !== $user->id && $user->role !== 'admin') {
            return $this->error('Forbidden', 403);
        }

        // Evitamos respuestas 200 sin cambios cuando el JSON es inválido o no trae campos actualizables
        $updatable = ['name', 'email', 'phone', 'address', 'description', 'price', 'subcategory_id'];
        $payload = $request->only($updatable);
        if (empty($payload)) {
            return $this->error('No data provided or invalid JSON', 422);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|array',
            'address.street' => 'sometimes|string|max:255',
            'address.city' => 'sometimes|string|max:255',
            'address.zip' => 'sometimes|string|max:20',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'subcategory_id' => 'sometimes|integer|exists:subcategories,id'
        ]);

        $service->update($payload);

        return $this->success($service, 'Service updated successfully', 200);
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
     *     @OA\Response(
     *         response=200,
     *         description="Service deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Service not found")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy(int $id)
    {
        $service = Service::find($id);

        if(!$service) {
            return $this->error('Service not found', 404);
        }

        $user = Auth::user();

        if($service->user_id !== $user->id && $user->role !== 'admin') {
            return $this->error('Forbidden', 403);
        }

        $service->delete();
        return $this->success(null, 'Service deleted successfully', 200);
    }
}
