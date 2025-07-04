<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Customer;
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

            $query = Order::with('order_details.food', 'customer', 'order_status', 'coupon');
            /** @var \App\Models\Account $account */
            $account = auth()->user();

            if ($account->is_admin === 0) {
                $account = $account->load('customers');
                $customer_id = $account->customers[0]->id;

                $query = $query->where('customer_id', $customer_id);
            }

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

            $page = request('page', 1);
            $per_page = request('per_page', 4);
            $total = $query->count();
            $last_page = ceil($total / $per_page);
            $query = $query->skip(($page - 1) * $per_page)->take($per_page);
            return response()->json([
                'status' => true,
                'data' => $query->get(),
                'page' => [
                    'current_page' => (int)$page,
                    'last_page' => $last_page,
                    'per_page' => (int)$per_page,
                    'total' => $total,
                ],
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
            DB::beginTransaction();
            Order::whereIn('id', $list_id)->update(['order_status_id' => $order_status_id]);

            if ($order_status_id === 4) {

                foreach ($list_id as $id) {
                    $order = Order::with('order_details')->where('id', $id)->first();
                    foreach ($order->order_details as $orderDetail) {
                        $food = Food::find($orderDetail->food_id);
                        $food->sold += $orderDetail->quantity;
                        $food->save();
                    }
                }
            }
            if ($order_status_id === 3) {
                Order::whereIn('id', $list_id)->update(['is_payment' => 1]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Update successful',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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
            /** @var \App\Models\Account $account */
            $account = auth()->user();
            $account = $account->load('customers');
            $customer_id = $account->customers[0]->id;
            $phone = request('phone');
            $address = request('address');
            $delivery_cost = request('delivery_cost');
            $coupon_id = request('coupon_id') === 0 ? null : request('coupon_id');
            $note = request('note');
            $is_payment = request('is_payment', 0);
            $cart_ids = request('cart_ids');

            if (!empty($phone) && !empty($address) && !empty($cart_ids) && is_array($cart_ids)) {

                DB::beginTransaction();
                $totalAmount = 0;
                $totalQuantity = 0;

                $order_details = Cart::with('food')->whereIn('id', $cart_ids)->get();
                if (count($order_details) === 0) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid.',
                    ], 400);
                }

                $orderDetailsToInsert = [];

                foreach ($order_details as $item) {

                    $quantity = $item->quantity;
                    $food = $item->food;
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
                    'is_payment' => $is_payment,
                    'order_status_id' => 1,
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
                if ($coupon_id) {
                    $coupon = Coupon::where('id', $coupon_id)->first();
                    $coupon->quantity -= 1;
                    $coupon->save();
                }
                Cart::whereIn('id', $cart_ids)->delete();





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
    //

    //
    public function statisticsCustomers()
    {
        try {
            $start_date = request('start_date');
            $end_date = request('end_date');

            $query = Order::select('customer_id', DB::raw('SUM(total_amount) as total_money_orders'), DB::raw('COUNT(*) as total_quantity_orders'))->where('order_status_id', 4);
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            $query = $query->groupBy('customer_id')->orderBy('total_money_orders', 'desc')->with('customer');

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
    public function statisticsOrders()
    {
        try {
            $start_date = request('start_date');
            $end_date = request('end_date');

            $query = Order::select('order_status_id', DB::raw('COUNT(*) as total_orders'));
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            $query = $query->groupBy('order_status_id')->with('order_status');

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
    public function statisticsRevennue()
    {
        try {
            $start_date = request('start_date');
            $end_date = request('end_date');

            $query = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('COUNT(*) as total_orders'),
            );
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
            $query = $query->where('order_status_id', 4)->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderBy(DB::raw('YEAR(created_at)'), 'desc')
                ->orderBy(DB::raw('MONTH(created_at)'), 'desc');

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
