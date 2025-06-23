<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CouponController extends Controller
{
    //
    public function storeCoupon()
    {
        try {
            $quantity = request('quantity');
            $min_order_value = request('min_order_value');
            $discount = request('discount');
            $description = request('description');
            $name = request('name');
            $expire_date = request('expire_date');
            $status = request('status');
            $is_public = request('is_public');

            $coupon = Coupon::create([
                'name' => $name,
                'quantity' => $quantity,
                'description' => $description,
                'discount' => $discount,
                'min_order_value' => $min_order_value,
                'status' => $status,
                'expire_date' => $expire_date,
                'is_public' => $is_public,
            ]);

            if ($is_public === 0) {
                $list_id = request('list_id');
                $coupon->customers()->actach($list_id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Create successful',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function updateCouponStatus()
    {
        try {
            $list_id = request('list_id');
            $updated_rows = Coupon::whereIn('id', $list_id)->update(['status' => 0]);

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
    public function getCoupons()
    {
        try {
            $status = request('status');
            $sort_by = request('sort_by');

            $query = Coupon::query();
            if ($status === 1 || $status === 0) {
                $query = $query->where('status', $status);
            }
            switch ($sort_by) {
                case 'min_order_value_asc':
                    $query->orderBy('min_order_value', 'asc');
                    break;
                case 'min_order_value_desc':
                    $query->orderBy('min_order_value', 'desc');
                    break;
                case 'discount_asc':
                    $query->orderBy('discount', 'asc');
                    break;
                case 'discount_desc':
                    $query->orderBy('discount', 'desc');
                    break;
                case 'quantity_asc':
                    $query->orderBy('quantity', 'asc');
                    break;
                case 'quantity_desc':
                    $query->orderBy('quantity', 'desc');
                    break;
                case 'expire_date_asc':
                    $query->orderBy('expire_date', 'asc');
                    break;
                case 'expire_date_desc':
                    $query->orderBy('expire_date', 'desc');
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
    public function getCouponsCustomer()
    {
        try {
            /** @var \App\Models\Account $account */
            $account = auth()->user();

            $query = Coupon::where('status', 1)->where('is_public', 1)->orderBy('discount', 'desc');
            if ($account) {
                $account = $account->load('customers');
                $id = $account->customers[0]->id;
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
}
