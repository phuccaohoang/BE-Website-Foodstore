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
            $query = Category::where('status', $status);
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
