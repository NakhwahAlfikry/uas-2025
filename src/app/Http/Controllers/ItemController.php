<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Helper\EncryptionHelper;

class ItemController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/items",
     *     operationId="getItems",
     *     tags={"Items"},
     *     summary="Get all items",
     *     description="Returns a list of all items.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Item")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Item::all();

        $response = [
            'message' => 'success',
            'data' => $data,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($response));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Post(
     *     path="/api/items",
     *     operationId="storeItem",
     *     tags={"Items"},
     *     summary="Create a new item",
     *     description="Stores a new item and returns the encrypted response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "quantity"},
     *             @OA\Property(property="name", type="string", example="Item A"),
     *             @OA\Property(property="quantity", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item created successfully",
     *         @OA\JsonContent(@OA\Property(property="data", type="string"))
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $item = Item::create($validated);

        $response = [
            'message' => 'Item created successfully',
            'data' => $item,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($response));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Get(
     *     path="/api/items/{id}",
     *     operationId="getItemById",
     *     tags={"Items"},
     *     summary="Get item by ID",
     *     description="Returns item data by its ID.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(@OA\Property(property="data", type="string"))
     *     ),
     *     @OA\Response(response=404, description="Item not found")
     * )
     */
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $response = [
            'message' => 'success',
            'data' => $item,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($response));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Put(
     *     path="/api/items/{id}",
     *     operationId="updateItem",
     *     tags={"Items"},
     *     summary="Update item",
     *     description="Update an existing item by ID.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Item"),
     *             @OA\Property(property="quantity", type="integer", example=20)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item updated successfully",
     *         @OA\JsonContent(@OA\Property(property="data", type="string"))
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
        ]);

        $item->update($validated);

        $response = [
            'message' => 'Item updated successfully',
            'data' => $item,
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($response));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     operationId="deleteItem",
     *     tags={"Items"},
     *     summary="Delete item",
     *     description="Delete item by ID.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item deleted successfully",
     *         @OA\JsonContent(@OA\Property(property="data", type="string"))
     *     )
     * )
     */
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        $response = [
            'message' => 'Item deleted successfully',
            'data' => ['id' => $id],
        ];

        $encrypted = EncryptionHelper::encrypt(json_encode($response));

        return response()->json(['data' => $encrypted]);
    }

    /**
     * @OA\Post(
     *     path="/api/items/decrypt",
     *     operationId="decryptItemResponse",
     *     tags={"Items"},
     *     summary="Decrypt item response",
     *     description="Decrypt encrypted item response.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data"},
     *             @OA\Property(property="data", type="string", example="eyJpdiI6...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Decryption successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Decryption failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function decryptResponse(Request $request)
    {
        $encrypted = $request->input('data');

        try {
            $decrypted = EncryptionHelper::decrypt($encrypted);
            $decoded = json_decode($decrypted, true);

            return response()->json($decoded);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Decrypt Failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
