<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    //
    public function statisticsFoods()
    {
        try {
            $start_date = request('start_date');
            $end_date = request('end_date');

            $query = OrderDetail::select('food_id', DB::raw('SUM(quantity) as total_quantity'));
            $query = $query->whereHas('order', function ($query) use ($start_date, $end_date) {
                $q = $query->where('order_status_id', 4);
                if ($start_date && $end_date) {
                    $q = $q->whereBetween('created_at', [$start_date, $end_date]);
                }
                return $q;
            });
            $query = $query->groupBy('food_id')->orderBy('total_quantity', 'desc')->with('food');

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
