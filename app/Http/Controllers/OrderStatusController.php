<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    // lay danh sach trang thai don hang
    public function getOrderStatus()
    {
        try {
            $all = request('all', 0);
            if (!$all) {
                $query = OrderStatus::where('id', '!=', 5);
                return response()->json([
                    'status' => true,
                    'data' => $query->get(),
                ], 200);
            }

            $query = OrderStatus::query();
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
}
