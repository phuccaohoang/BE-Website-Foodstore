<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function disableReview()
    {
        try {
            $list_id = request('list_id');

            $updated_rows = Review::whereIn('id', $list_id)->update(['status' => 0]);

            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Disable successful',
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
