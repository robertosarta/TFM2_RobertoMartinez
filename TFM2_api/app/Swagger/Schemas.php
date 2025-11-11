<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="CategoryBasic",
 *     title="CategoryBasic",
 *     description="Category without nested subcategories",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Technology")
 * )
 *
 * @OA\Schema(
 *     schema="SubcategoryBasic",
 *     title="SubcategoryBasic",
 *     description="Subcategory without nested category",
 *     type="object",
 *     required={"id", "name", "category_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Laptops"),
 *     @OA\Property(property="category_id", type="integer", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="UserBasic",
 *     title="UserBasic",
 *     description="User core fields without relations",
 *     type="object",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com")
 * )
 *
 * @OA\Schema(
 *     schema="ServiceBasic",
 *     title="ServiceBasic",
 *     description="Service fields without relations",
 *     type="object",
 *     required={"id", "name", "email", "phone", "price"},
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="name", type="string", example="Computer Repair"),
 *     @OA\Property(property="email", type="string", example="robertosarta@gmail.com"),
 *     @OA\Property(property="phone", type="string", example="+34 600 987 654"),
 *     @OA\Property(
 *         property="address",
 *         type="object",
 *         @OA\Property(property="street", type="string", example="456 Service St"),
 *         @OA\Property(property="city", type="string", example="Barcelona"),
 *         @OA\Property(property="zip", type="string", example="08001")
 *     ),
 *     @OA\Property(property="description", type="string", example="Repair and maintenance of laptops and PCs"),
 *     @OA\Property(property="price", type="string", example="49.99"),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="subcategory_id", type="integer", example=5)
 * )
 */
class Schemas {}

