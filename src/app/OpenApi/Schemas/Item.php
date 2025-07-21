<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Item",
 *     type="object",
 *     title="Item",
 *     required={"id", "name", "sku", "stock"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Lampu LED 12W"),
 *     @OA\Property(property="sku", type="string", example="SKU-LED-001"),
 *     @OA\Property(property="category_id", type="integer", nullable=true, example=2),
 *     @OA\Property(property="stock", type="integer", example=100),
 *     @OA\Property(property="description", type="string", example="Lampu LED putih terang 12 watt"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-02T08:30:00Z")
 * )
 */
class Item {}
