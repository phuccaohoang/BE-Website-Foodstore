<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use App\Models\Image;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    // lay danh sach voi bo loc
    public function getFoods()
    {
        try {
            $name = request('name');
            $category = request('category_id');
            $status = request('status');
            $sort_by = request('sort_by');




            $query = Food::with('category', 'images')->whereHas('category', function ($query) {
                $query->where('status', 1);
            });;

            if (!empty($name)) {
                $query = $query->where('name', 'LIKE', '%' . $name . '%');
            }
            if (!empty($category)) {
                $query = $query->where('category_id', $category);
            }
            if ($status == 1 || $status == 0) {
                $query = $query->where('status', $status);
            }
            switch ($sort_by) {
                case 'sold_asc':
                    $query->orderBy('sold', 'asc');
                    break;
                case 'sold_desc':
                    $query->orderBy('sold', 'desc');
                    break;
                case 'discount_asc':
                    $query->orderBy('discount', 'asc');
                    break;
                case 'discount_desc':
                    $query->orderBy('discount', 'desc');
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
    // lay mon an theo slug
    public function getFood()
    {
        try {
            $slug = request('slug');
            $query = Food::with('category', 'reviews.customer.account', 'reviews.feedbacks.administrator.account', 'images')->where('slug', $slug);

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
    // thay doi trang thai mon an
    public function updateFoodStatus()
    {
        try {
            $list_id = request('list_id');
            $status = request('status');

            if (empty($list_id) || !is_array($list_id) || ($status != 1 && $status != 0)) {
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
                'status' => false,
                'message' => '0 row updated',
            ], 400);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // cap nhat thong tin ve mon an
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



            if (!empty($category_id) && is_numeric($category_id) && $category_id > 0) {
                $categoryExists = Category::where('id', $category_id)->exists();
                if ($categoryExists) {
                    $updates['category_id'] = $category_id;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid 1.',
                    ], 400);
                }
            }

            if (isset($price) && $price !== '' && is_numeric($price) && $price >= 0) {
                $updates['price'] = $price;
            }

            if (isset($discount) && $discount !== '' && is_numeric($discount) && $discount >= 0 && $discount <= 100) {
                $updates['discount'] = $discount;
            }


            if (!empty($updates)) {

                Food::whereIn('id', $list_id)->update($updates);
            }

            return response()->json([
                'status' => true,
                'message' => 'Update successful',
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => $list_id,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //cap nhat mot foof
    public function updateFood()
    {

        try {
            $id = request('id');
            $category_id = request('category_id');
            $price = request('price');
            $discount = request('discount');


            $updates = [];



            $name = request('name');
            $description = request('description');

            $description = is_string($description) ? trim($description) : '';
            $name = is_string($name) ? trim($name) : '';
            if (!empty($name)) {
                $updates['name'] = $name;
            }
            if (!empty($description)) {
                $updates['description'] = $description;
            }



            if (!empty($category_id) && is_numeric($category_id) && $category_id > 0) {
                $categoryExists = Category::where('id', $category_id)->exists();
                if ($categoryExists) {
                    $updates['category_id'] = $category_id;
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Request invalid 1.',
                    ], 400);
                }
            }

            if (isset($price) && $price !== '' && is_numeric($price) && $price >= 0) {
                $updates['price'] = $price;
            }

            if (isset($discount) && $discount !== '' && is_numeric($discount) && $discount >= 0 && $discount <= 100) {
                $updates['discount'] = $discount;
            }

            DB::beginTransaction();
            if (!empty($updates)) {

                Food::where('id', $id)->update($updates);
            }


            if (request()->hasFile('images')) {

                $images = request()->file('images');
                Image::where('food_id', $id)->delete();
                $idx = 0;
                foreach ($images as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $path = $file->storeAs('foods', $id . '-' . $idx . '.' . $extension);
                    Image::create([
                        'food_id' => $id,
                        'img' => $path,
                    ]);
                    $idx += 1;
                }
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
    // them moi mon an
    public function storeFood()
    {
        try {
            $category_id = request('category_id');
            $price = request('price');
            $discount = request('discount');
            $description = request('description');
            $name = request('name');
            $status = request('status');
            DB::beginTransaction();
            $food = Food::create([
                'name' => $name,
                'category_id' => $category_id,
                'slug' => Str::slug($name),
                'description' => $description,
                'discount' => $discount,
                'price' => $price,
                'status' => $status,
            ]);

            $files = request()->file('images');

            $idx = 0;
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $path = $file->storeAs('foods', $food->id . '-' . $idx . '.' . $extension);
                Image::create([
                    'food_id' => $food->id,
                    'img' => $path,
                ]);
                $idx += 1;
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Create successful',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
