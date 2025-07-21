<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Helper\EncryptionHelper;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transactions",
     *     operationId="getTransactions",
     *     tags={"Transactions"},
     *     summary="Get all transactions",
     *     description="Returns a list of all transactions.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Transaction")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $data = Transaction::with('item')->get();

        $response = [
            'message' => 'success',
            'data' => $data,
        ];

        return response()->json([
            'data' => EncryptionHelper::encrypt(json_encode($response)),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     operationId="storeTransaction",
     *     tags={"Transactions"},
     *     summary="Create a new transaction",
     *     description="Stores a new transaction and adjusts item stock.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"item_id", "type", "quantity"},
     *             @OA\Property(property="item_id", type="integer", example=1),
     *             @OA\Property(property="type", type="string", example="masuk"),
     *             @OA\Property(property="quantity", type="integer", example=5),
     *             @OA\Property(property="description", type="string", example="Stock update")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(@OA\Property(property="data", type="string"))
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['type'] === 'keluar') {
            if ($item->quantity < $validated['quantity']) {
                return response()->json(['message' => 'Stok tidak cukup'], 400);
            }

            $item->quantity -= $validated['quantity'];
        } else {
            $item->quantity += $validated['quantity'];
        }

        $item->save();

        $transaction = Transaction::create([
            'item_id' => $item->id,
            'user_id' => Auth::id() ?? 1,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'] ?? null,
        ]);

        $response = [
            'message' => 'Transaction created successfully',
            'data' => $transaction,
        ];

        return response()->json([
            'data' => EncryptionHelper::encrypt(json_encode($response)),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     operationId="getTransactionById",
     *     tags={"Transactions"},
     *     summary="Get transaction by ID",
     *     description="Returns transaction data by ID.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show($id)
    {
        $transaction = Transaction::with('item')->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $response = [
            'message' => 'success',
            'data' => $transaction,
        ];

        return response()->json([
            'data' => EncryptionHelper::encrypt(json_encode($response)),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     operationId="deleteTransaction",
     *     tags={"Transactions"},
     *     summary="Delete transaction",
     *     description="Deletes a transaction record.",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted successfully")
     * )
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        $response = [
            'message' => 'Transaction deleted',
            'data' => ['id' => $id],
        ];

        return response()->json([
            'data' => EncryptionHelper::encrypt(json_encode($response)),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/transactions/decrypt",
     *     operationId="decryptTransactionResponse",
     *     tags={"Transactions"},
     *     summary="Decrypt transaction response",
     *     description="Decrypt encrypted transaction response.",
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
     *         description="Decryption successful"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Decryption failed"
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
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
