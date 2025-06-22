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

            if ($updated_rows) {
                return response()->json([
                    'status' => true,
                    'message' => 'Disable successful',
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => '0 row updated.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //
    public function getReviews()
    {
        try {
            $is_feedback = request('is_feedback');
            $status = request('status');
            $sort_by = request('sort_by');

            $query = Review::with('feedbacks', 'food', 'customer');
            if ($is_feedback === 1) {
                $query = $query->has('feedbacks');
            }
            if ($is_feedback === 0) {
                $query = $query->doesntHave('feedbacks');
            }
            if (!empty($status)) {
                $query = $query->where('status', $status);
            }
            switch ($sort_by) {
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
}
