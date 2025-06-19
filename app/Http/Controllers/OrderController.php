<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function getOrders()
    {
        try {
            $status = request('status');
            $sort_by = request('sort_by');
            $fullname = request('fullname');

            $query = Order::with('order_details.food', 'customer');
            if (!empty($status)) {
                $query = $query->where('status', $status);
            }
            if (!empty($fullname)) {
                $query = $query->whereRelation('customer', 'fullname', 'LIKE', '%' . $fullname . '%');
            }
            switch ($sort_by) {
                case 'total_amount_asc':
                    $query->orderBy('total_amount', 'asc');
                    break;
                case 'total_amount_desc':
                    $query->orderBy('total_amount', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

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
    //
    public function updateOrderStatus()
    {
        try {
            $list_id = request('list_id');
            $order_status_id = request('order_status_id');

            $updated_rows = Order::whereIn('id', $list_id)->update(['order_status_id' => $order_status_id]);

            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Update successful',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function cancelOrder()
    {
        try {
            $list_id = request('list_id');
            $note = request('note');

            $updated_rows = Order::whereIn('id', $list_id)->update([
                'note' => $note,
                'order_status_id' => 5
            ]);

            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Cancel successful',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
