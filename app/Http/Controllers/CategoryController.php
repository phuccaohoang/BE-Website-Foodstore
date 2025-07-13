<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // lay danh sach loai mon an 
    public function getCategories()
    {
        try {
            $status = request('status', 1);
            $name = request('name');

            $query = Category::query();

            if ($status == 1 || $status == 0) {
                $query = $query->where('status', $status);
            }

            if (!empty($name)) {
                $query = $query->where('name', 'LIKE', '%' . $name . '%');
            }

            $page = request('page', 1);
            $per_page = request('per_page', 4);
            $total = $query->count();
            $last_page = ceil($total / $per_page);

            if ($per_page != -1) {

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
    // them loai
    public function storeCategory()
    {
        try {
            $name = request('name');

            Category::create([
                'name' => $name,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'store successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // cap nhat loai mon an
    public function updateCategory()
    {
        try {
            $name = request('name');
            $status = request('status');
            $id = request('id');

            Category::where('id', $id)->update([
                'name' => $name,
                'status' => $status,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'updated successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
