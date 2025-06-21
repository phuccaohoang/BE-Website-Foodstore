<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // lay tat ca cac don hang
    public function getOrders()
    {
        try {
            $order_status_id = request('order_status_id');
            $sort_by = request('sort_by');
            $fullname = request('fullname');

            $query = Order::with('order_details.food', 'customer', 'order_status');

            if ($customer_id = 2) {

                $query = $query->where('customer_id', $customer_id);
            }
            // if (auth()->user()->is_admin === 0) {
            //     $customer_id = auth()->user()->customers[0]->id;
            //     $query = $query->where('customer_id', $customer_id);
            // }

            if (!empty($order_status_id)) {
                $query = $query->where('order_status_id', $order_status_id);
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
    // cap nhat trang thai don hang
    public function updateOrderStatus()
    {
        try {
            $list_id = request('list_id');
            $order_status_id = request('order_status_id');

            if (empty($list_id) || !is_array($list_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

            $updated_rows = Order::whereIn('id', $list_id)->update(['order_status_id' => $order_status_id]);

            if ($updated_rows) {
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
    // huy don
    public function cancelOrder()
    {
        try {
            $list_id = request('list_id');
            $note = request('note');

            if (empty($list_id) || !is_array($list_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

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
    // them don hang 
    public function storeOrder()
    {
        try {
            $customer_id = 1;
            // $customer_id = auth()->user()->customers[0]->id;
            $phone = request('phone');
            $address = request('address');
            $delivery_cost = request('delivery_cost');
            $coupon_id = request('coupon_id');
            $note = request('note');
            $order_details = request('order_details');

            if (!empty($phone) && !empty($address) && !empty($order_details) && is_array($order_details)) {

                DB::beginTransaction();
                $totalAmount = 0;
                $totalQuantity = 0;
                $orderDetailsToInsert = [];

                $food_ids = collect($order_details)->pluck('food_id')->unique()->toArray();
                $foods = Food::whereIn('id', $food_ids)->get()->keyBy('id');

                foreach ($order_details as $item) {
                    $food_id = $item['food_id'];
                    $quantity = $item['quantity'];

                    if (!isset($foods[$food_id])) {

                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Một số món ăn không hợp lệ hoặc không tồn tại.',
                        ], 400);
                    }

                    $food = $foods[$food_id];
                    $price = $food->price;
                    $discount = $food->discount;

                    $itemPrice = $price * ((100 - $discount) / 100);
                    $totalAmount += $itemPrice * $quantity;
                    $totalQuantity += $quantity;

                    $orderDetailsToInsert[] = [
                        'order_id' => null,
                        'food_id' => $food->id,
                        'price' => $price,
                        'discount' => $discount,
                        'quantity' => $quantity,
                    ];
                }

                $order = Order::create([
                    'customer_id' => $customer_id,
                    'phone' => $phone,
                    'address' => $address,
                    'delivery_cost' => $delivery_cost,
                    'coupon_id' => $coupon_id,
                    'note' => $note,
                    'total_amount' => $totalAmount,
                    'quantity' => $totalQuantity,
                ]);

                foreach ($orderDetailsToInsert as &$item) {
                    $item['order_id'] = $order->id;
                }

                $check = OrderDetail::insert($orderDetailsToInsert);

                if (!$check) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Không thể lưu chi tiết đơn hàng. Vui lòng thử lại.',
                    ], 500);
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Đơn hàng đã được tạo thành công.',
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => 'Request invalid.',
            ], 400);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
