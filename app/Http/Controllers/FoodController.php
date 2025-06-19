<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Food;
use Exception;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    //
    public function getFoods()
    {
        try {
            $name = request('name');
            $category = request('category');
            $status = request('status');
            $sort_by = request('sort_by');


            $query = Food::with('category');

            if (!empty($name)) {
                $query = $query->where('name', 'LIKE', '%' . $name . '%');
            }
            if (!empty($category)) {
                $query = $query->where('category_id', $category);
            }
            if ($status === 1 || $status === 0) {
                $query = $query->where('status', $status);
            }
            switch ($sort_by) {
                case 'sold_asc':
                    $query->orderBy('sold', 'asc');
                    break;
                case 'sold_desc':
                    $query->orderBy('sold', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating_asc':
                    $query->orderBy('rating', 'asc');
                    break;
                case 'rating_desc':
                    $query->orderBy('rating', 'desc');
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
    public function updateFoodStatus()
    {
        try {
            $list_id = request('list_id');
            $status = request('status');

            if (empty($list_id) || !is_array($list_id) || ($status !== 1 && $status !== 0)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

            $updated_rows = Food::whereIn('id', $list_id)->update(['status' => $status]);

            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Update successful',
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => '0 row updated',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function updateFoods()
    {
        try {
            $list_id = request('list_id');
            $category_id = request('category_id');
            $price = request('price');
            $discount = request('discount');


            $updates = [];


            if (empty($list_id) || !is_array($list_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

            if (count($list_id) === 1) {
                $name = request('name');
                $description = request('description');
                if (!empty($name)) {
                    $updates['name'] = $name;
                }
                if (!empty($description)) {
                    $updates['description'] = $description;
                }
            }


            if (!empty($category_id)) {
                $categoryExists = Category::where('id', $category_id)->exists();
                if ($categoryExists) {
                    $updates['category_id'] = $category_id;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid.',
                    ], 400);
                }
            }

            if (isset($price) && $price !== '') {
                if (is_numeric($price) && $price >= 0) {
                    $updates['price'] = $price;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid.',
                    ], 400);
                }
            }

            if (isset($discount) && $discount !== '') {
                if (is_numeric($discount) && $discount >= 0 && $discount <= 100) {
                    $updates['discount'] = $discount;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid.',
                    ], 400);
                }
            }

            if (empty($updates)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid.',
                ], 400);
            }

            $updated_rows = Food::whereIn('id', $list_id)->update($updates);

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
    public function storeFood()
    {
        try {
            $category_id = request('category_id');
            $price = request('price');
            $discount = request('discount');
            $description = request('description');
            $name = request('name');
            $status = request('status');

            $food = Food::create([
                'name' => $name,
                'category_id' => $category_id,
                'description' => $description,
                'discount' => $discount,
                'price' => $price,
                'status' => $status,
            ]);

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
}
