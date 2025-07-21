<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     title="Transaction",
 *     required={"id", "item_id", "user_id", "type", "quantity"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="item_id", type="integer", example=3),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="type", type="string", enum={"masuk", "keluar"}, example="masuk"),
 *     @OA\Property(property="quantity", type="integer", example=10),
 *     @OA\Property(property="description", type="string", nullable=true, example="Penambahan stok dari supplier"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-02T08:30:00Z")
 * )
 */
class Transaction {}
