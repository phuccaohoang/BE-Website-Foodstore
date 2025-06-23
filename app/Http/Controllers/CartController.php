<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // lay mon an theo slug
    public function getCart()
    {
        try {
            /** @var \App\Models\Account $account */

            $account = auth()->user();


            $account = $account->load('customers');
            $query = Cart::with('food.images')->where('customer_id', $account->customers[0]->id);

            return response()->json([
                'status' => true,
                'data' => $query->get(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // thay doi so luong mon an
    public function updateCart()
    {
        try {
            $id = request('id');

            $quantity = request('quantity');

            $updated_rows = Cart::where('id', $id)->update(['quantity' => $quantity]);
            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Update successful.',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => '0 row updated.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // them vao gio hang
    public function storeCart()
    {
        try {
            /** @var \App\Models\Account $account */

            $account = auth()->user();
            $account = $account->load('customers');
            $customer_id = $account->customers[0]->id;
            $food_id = request('food_id');
            $quantity = request('quantity');

            $cart = Cart::where('customer_id', $customer_id)->where('food_id', $food_id)->first();
            if ($cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Exists.',
                ], 400);
            }

            Cart::create([
                'customer_id' => $customer_id,
                'food_id' => $food_id,
                'quantity' => $quantity,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Store successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // xoa khoi gio hang
    public function deleteCarts()
    {
        try {
            $list_id = request('list_id');
            if (empty($list_id) || !is_array($list_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

            $deleted_rows = Cart::whereIn('id', $list_id)->delete();
            if ($deleted_rows) {

                return response()->json([
                    'status' => true,
                    'message' => 'Delete successful.',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Request invalid.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
